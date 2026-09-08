<?php
/**
 * Oviya theme functions and definitions.
 * 
 * Copyright (C) 2026 Apur Group (Nikhil Devre)
 * This program is free software; you can redistribute it and/or modify it under the terms of the MIT License.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package Oviya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'OVIYA_VERSION', '1.0.2' );
define( 'OVIYA_DIR', get_template_directory() );
define( 'OVIYA_URI', get_template_directory_uri() );

require OVIYA_DIR . '/inc/setup.php';
require OVIYA_DIR . '/inc/enqueue.php';
require OVIYA_DIR . '/inc/customizer.php';
require OVIYA_DIR . '/inc/template-tags.php';
require OVIYA_DIR . '/inc/content-filters.php';
require OVIYA_DIR . '/inc/user-meta.php';
require OVIYA_DIR . '/inc/comments.php';
require OVIYA_DIR . '/inc/meta-boxes.php';
