<?php
$auth_routes = [
	'Administración' => [
		[
			'name' => 'Reservas',
			'path' => '/auth/reservas',
			'svg' => 'List'
		],
        [
            'name' => 'Tipo Habitación y Salón',
            'path' => '/auth/tipohabsal',
            'svg' => 'List'
        ],
		[
			'name' => 'Inventario General',
			'path' => '/auth/inventario',
			'svg' => 'List'
		]
        ,
		[
			'name' => 'Instalación Horarios',
			'path' => '/auth/instalacion',
			'svg' => 'List'
        ]
		,
        [
			'name' => 'Limpieza Programada',
			'path' => '/auth/limpieza',
			'svg' => 'Limpieza'
		]


	],
	'Personal' => [
		[
			'name' => 'Personal',
			'path' => '/auth/personal',
			'svg' => 'People'
        ],
        
        [
            'name' => 'Evaluación',
            'path' => '/auth/evaluacion',
            'svg' => 'People'
        ] ,
        [
            'name' => 'Asistencia',
            'path' => '/auth/personal/asistencia',
            'svg' => 'People'
        ],
        [
            'name' => 'Horarios',
            'path' => '/auth/personal/horario',
            'svg' => 'Clock'
        
        ],  
        [
            'name' => 'Pagos Personal',
            'path' => '/auth/Pagos',
            'svg' => 'List' 
        ],
        [
            'name' => 'Roles de pago',
            'path' => '/auth/roles',
            'svg' => 'List' 
        ]
    ],
    'Egresos' => [
		[
			'name' => 'Egresos',
			'path' => '/auth/egresos',
			'svg' => 'List'
        ],
        [
			'name' => 'Pago Sueldos',
			'path' => '/auth/egresos/pago_sueldos',
			'svg' => 'People'
		],
        [
			'name' => 'Pago Personal',
			'path' => '/auth/egresos/pago_aporte_personal',
			'svg' => 'People'
		],
        [
			'name' => 'Pagos Patronal',
			'path' => '/auth/egresos/pago_aporte_patronal',
			'svg' => 'People'
		],
        [
			'name' => 'Egresos Totales',
			'path' => '/auth/egresos/egresos_totales',
			'svg' => 'People'
		],
        [
			'name' => 'Egresos Inactivos',
			'path' => '/auth/egresos/inactivos',
			'svg' => 'People'
		]
    ],
    'Ingresos' => [
		[
			'name' => ' Registro Ingreso',
			'path' => '/auth/ingresos/registrar',
			'svg' => 'List'
        ],
        [
			'name' => 'Ingresos Realizados',
			'path' => '/auth/ingresos/ingresos_realizados',
			'svg' => 'List'
		]
       
    ],
    'Marketing' => [
		[
			'name' => ' Servicios',
			'path' => '/auth/marketing',
			'svg' => 'List'
		],
        [
			'name' => ' Promociones',
			'path' => '/auth/marketing/promociones',
			'svg' => 'Promociones'
		],
        [
			'name' => ' Clientes',
			'path' => '/auth/marketing/clientes',
			'svg' => 'People'
		]
    ],

    'Seguridad' => [
		[
			'name' => ' Seguridad',
			'path' => '/auth/seguridad',
			'svg' => 'List'
		],
        [
			'name' => ' Auditoría',
			'path' => '/auth/auditoria',
			'svg' => 'List'
		],
    ],  
    
];



$currentPath = $_SERVER['REQUEST_URI'];
?>

<aside class="fixed top-1/2 -translate-y-1/2 mt-2 left-0 min-h-[calc(100vh-9rem)] md:w-96 bg-background-900 px-8 py-6 transition-transform duration-200 hover:translate-x-0 -translate-x-full rounded-r-xl border-y-2 border-r-2 border-y-accent-600 border-r-accent-600">
    <nav class="flex flex-col items-center justify-center w-full h-full">
        <?php foreach ($auth_routes as $key => $route): ?>
        <div class="relative flex flex-col group w-full gap-y-4">
            <div class="relative w-full flex justify-between items-center border-b py-2">
                <p class="text-white w-full capitalize"><?= $key ?></p>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-text-50">
                    <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="hidden grid-cols-3 gap-3 group-hover:grid place-items-center transition-all duration-300">
              <?php foreach ($route as $item): ?>
                  <a href="<?= $item['path'] ?>" class="aspect-square w-full bg-background-950 text-center rounded-lg flex flex-col gap-y-2 items-center justify-center border-2 border-accent-600 text-text-50
                  <?= $currentPath === $item['path']
                    ? 'bg-background-600'
                    : ''
                  ?>">
                    <?php require base_path('views/partials/icons/' . $item['svg'] . '.php') ?>
                    <?php echo $item['name'] ?>
                  </a>
              <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </nav>
    <button class="absolute top-1/2 right-0 translate-x-4 bg-accent-600 h-12 w-4 rounded-r-lg flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-text-50">
            <path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd" />
        </svg>

    </button>
</aside>