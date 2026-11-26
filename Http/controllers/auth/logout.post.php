<?php
use Core\Auth;

(new Auth())->logout();

redirect('/auth/login');
