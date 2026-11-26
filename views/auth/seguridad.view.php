
<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950 text-text-50">
    <div class="container mx-auto flex flex-col justify-center px-4 py-8">
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Administración De Usuarios</h1>
        <?php if (isset($success)): ?>
            <div class="mb-4 p-2 bg-green-100 border border-green-400 text-green-700 rounded">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="mb-4 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="flex w-full p-4 rounded-lg">
            <div class="flex flex-row w-full justify-between gap-x-2 items-center">
                <div class="px-2 w-1/2">
                    <form class="flex items-center" onsubmit="return false;">
                        <label class="px-2 text-m text-text-50">Buscar:</label>
                        <input type="text" id="search" class="inp" placeholder="Buscar usuario por id, email o rol" onkeyup="buscar()">
                    </form>
                </div>
                <div class="px-2 w-fit flex items-center gap-2">
                    <a href="/auth/auditoria" class="items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-accent-800 text-text-50 hover:bg-accent-700">Auditoría</a>
                    <a href="/auth/register" class="items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Crear nuevo usuario</a>
                </div>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
    <div class="w-full flex justify-center">
        <table class="min-w-full divide-y divide-background-800" id="hola">
                <thead class="bg-background-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">ID</th>
                        <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">Email</th>
                        <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">Rol</th>
                        <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-800">
                
                
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                                <td class="px-4 py-2 text-center"><?= $user['USU_ID'] ?></td>
                                <td class="px-4 py-2 text-center"><?= $user['USU_NOM'] ?></td>
                                <td class="px-4 py-2 text-center"><?= $user['USU_ROL'] ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'>
                                    <div class="flex justify-center items-center space-x-2">
                                    
                                        
                                        <button onclick="editUser(<?= $user['USU_ID'] ?>, '<?= $user['USU_NOM'] ?>', '<?= $user['USU_ROL'] ?>')" type="submit" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                            </svg>
                                        </button>
                                    
                                        <button onclick="deleteUser(<?= $user['USU_ID'] ?>)" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path  d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"  />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-white text-center">No hay usuarios para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </div>
        

        <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <h3 class="text-black text-lg font-bold mb-4">Editar Usuario</h3>
                <form id="editForm" method="POST" action="/auth/seguridad">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" id="editUserId" name="userId">
                    <div class="mb-4">
                        <label for="editEmail" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="editEmail" name="email" class="w-full px-3 py-2 text-black border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="editRole" class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
                        <select id="editRole" name="role" class="w-full px-3 py-2 border text-black border-gray-300 rounded-md" required>
                        <option value="auth">Súper Usuario</option>
                        <option value="administracion">Administración</option>
                        <option value="personal">Personal</option>
                        <option value="marketing">Marketing</option>
                        <option value="seguridad">Seguridad</option>
                        <option value="ingresos">Ingresos</option>
                        <option value="egresos">Egresos</option>

                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="editPassword" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña (opcional)</label>
                        <input type="password" id="editPassword" name="password" class="w-full px-3 py-2 text-black border border-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="closeEditModal()" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded mr-2">
                            Cancelar
                        </button>
                        <button type="submit" class="grid h-10 place-items-center rounded-md p-1 font-normal transition-colors duration-200 w-30 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        

        
    </div>

    <script>
        function editUser(userId, email, role) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editUserId').value = userId;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function deleteUser(userId) {
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '/auth/seguridad';
                
                var actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'delete';
                form.appendChild(actionInput);

                var userIdInput = document.createElement('input');
                userIdInput.type = 'hidden';
                userIdInput.name = 'userId';
                userIdInput.value = userId;
                form.appendChild(userIdInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function buscar() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('hola');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                }

                if (match) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
</script>

    

</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>