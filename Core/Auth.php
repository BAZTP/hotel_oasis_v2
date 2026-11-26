<?php

namespace Core;

class Auth
{
    public function try($email, $password): bool
    {
        error_log("Intento de inicio de sesión para el email: $email");

        $db = Database::getInstance();
        
        $query = "SELECT USU_ID, USU_NOM, USU_CON_HAS, USU_ROL FROM seg_usuario WHERE USU_NOM = :email";
        
        try {
            $stmt = $db->prepare($query);
            $stmt->bind(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();

            error_log("Resultado de la consulta: " . print_r($user, true));

            if ($user) {
                error_log("Usuario encontrado. Comparando contraseñas.");
                $isValidHash = password_verify($password, $user['USU_CON_HAS']);
                $isLegacyPlain = !$isValidHash && password_get_info($user['USU_CON_HAS'])['algo'] === null && $password === $user['USU_CON_HAS'];

                if ($isValidHash || $isLegacyPlain) {
                    if ($isLegacyPlain) {
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        $db->prepare("UPDATE seg_usuario SET USU_CON_HAS = :hash WHERE USU_ID = :id")
                           ->bind(':hash', $newHash)
                           ->bind(':id', $user['USU_ID'])
                           ->execute();
                    }
                    error_log("Contraseña correcta. Iniciando sesión.");
                    $this->login($user);
                    return true;
                } else {
                    error_log("Contraseña incorrecta.");
                }
            } else {
                error_log("Usuario no encontrado.");
            }
        } catch (\Exception $e) {
            error_log("Error en la consulta a la base de datos: " . $e->getMessage());
        }

        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'id' => $user['USU_ID'],
            'name' => $user['USU_NOM'],
            'role' => $user['USU_ROL']
        ];

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }

        self::logAction("Inicio de sesión: " . $user['USU_NOM'], (int)$user['USU_ID']);
        error_log("Sesión iniciada para el usuario: " . $user['USU_NOM']);
    }

    public function register($email, $password, $role, $persId = null): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El correo electrónico no es válido.");
        }

        if (strlen($password) < 3) {
            throw new \InvalidArgumentException("La contraseña debe tener al menos 3 caracteres.");
        }

        if (!in_array($role, ['auth', 'administracion', 'personal', 'marketing', 'seguridad', 'ingresos', 'egresos'])) {
            throw new \InvalidArgumentException("El rol especificado no es válido.");
        }

        if ($this->emailExists($email)) {
            throw new \InvalidArgumentException("Este correo electrónico ya está en uso.");
        }

        $db = Database::getInstance();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO seg_usuario (PERS_ID, USU_NOM, USU_CON_HAS, USU_ROL) VALUES (:persId, :email, :password, :role)";

        try {
            $db->prepare($query)
               ->bind(':persId', $persId)
               ->bind(':email', $email)
               ->bind(':password', $hashedPassword)
               ->bind(':role', $role)
               ->execute();

            self::logAction("Usuario creado: $email ($role)");
            error_log("Usuario registrado exitosamente: $email");
            return true;
        } catch (\Exception $e) {
            error_log("Error en el registro: " . $e->getMessage());
            throw new \RuntimeException("Error al registrar el usuario. Por favor, inténtalo de nuevo.");
        }
    }

    public function emailExists($email): bool
    {
        $db = Database::getInstance();
        $query = "SELECT COUNT(*) as count FROM seg_usuario WHERE USU_NOM = :email";

        try {
            $result = $db->prepare($query)
                         ->bind(':email', $email)
                         ->execute()
                         ->fetch();

            return $result['count'] > 0;
        } catch (\Exception $e) {
            error_log("Error al verificar el correo electrónico: " . $e->getMessage());
            throw new \RuntimeException("Error al verificar el correo electrónico.");
        }
    }

    public function logout(): void
    {
        $name = $_SESSION['user']['name'] ?? 'Desconocido';
        self::logAction("Cierre de sesión: $name");
        error_log("Cerrando sesión para el usuario: " . $name);
        Session::destroy();
    }

    public static function logAction(string $description, ?int $userId = null): void
    {
        try {
            $uid = $userId ?? ($_SESSION['user']['id'] ?? null);
            $db = Database::getInstance();
            $db->prepare("INSERT INTO seg_registro_accion (USU_ID, ACC_DES) VALUES (:usu_id, :acc_des)")
                ->bind(':usu_id', $uid)
                ->bind(':acc_des', mb_substr($description, 0, 250))
                ->execute();
        } catch (\Throwable $e) {
            error_log("Error al registrar auditoría: " . $e->getMessage());
        }
    }

    public function hasPermission($requiredRole): bool
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role'])) {
            return false;
        }

        $userRole = strtolower($_SESSION['user']['role']);

        // El rol 'auth' o 'admin' tiene acceso a todo
        if ($userRole === 'auth' || $userRole === 'admin') {
            return true;
        }

        // Para otros roles, verificar si coincide con el rol requerido
        return $userRole === strtolower($requiredRole);
    }
    public function getAllUsers(): array
    {
        $db = Database::getInstance();
        $query = "SELECT USU_ID, USU_NOM, USU_ROL FROM seg_usuario";
    
        try {
            $stmt = $db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            error_log("Usuarios obtenidos: " . print_r($result, true));
            
            return $result;
        } catch (\Exception $e) {
            error_log("Error al obtener todos los usuarios: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }

public function updateUser($userId, $email, $role, $password = null): bool
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new \InvalidArgumentException("El correo electrónico no es válido.");
    }

    if (!in_array($role, ['auth', 'administracion', 'personal', 'marketing', 'seguridad', 'ingresos', 'egresos'])) {
        throw new \InvalidArgumentException("El rol especificado no es válido.");
    }

    $db = Database::getInstance();
    $query = "UPDATE seg_usuario SET USU_NOM = :email, USU_ROL = :role";
    $params = [':userId' => $userId, ':email' => $email, ':role' => $role];

    if ($password !== null) {
        if (strlen($password) < 3) {
            throw new \InvalidArgumentException("La contraseña debe tener al menos 3 caracteres.");
        }
        $query .= ", USU_CON_HAS = :password";
        $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    $query .= " WHERE USU_ID = :userId";

    try {
        $stmt = $db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bind($key, $value);
        }
        $stmt->execute();

        self::logAction("Usuario actualizado: $email ($role)");
        error_log("Usuario actualizado exitosamente: $email");
        return true;
    } catch (\Exception $e) {
        error_log("Error en la actualización del usuario: " . $e->getMessage());
        throw new \RuntimeException("Error al actualizar el usuario. Por favor, inténtalo de nuevo.");
    }
}

public function deleteUser($userId): bool
{
    $db = Database::getInstance();
    $query = "DELETE FROM seg_usuario WHERE USU_ID = :userId";

    try {
        $stmt = $db->prepare($query);
        $stmt->bind(':userId', $userId);
        $stmt->execute();

        self::logAction("Usuario eliminado (ID: $userId)");
        error_log("Usuario eliminado exitosamente: ID $userId");
        return true;
    } catch (\Exception $e) {
        error_log("Error al eliminar el usuario: " . $e->getMessage());
        throw new \RuntimeException("Error al eliminar el usuario. Por favor, inténtalo de nuevo.");
    }
}
}