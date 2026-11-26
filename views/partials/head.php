<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $head_title ?? 'Home' ?> | Hotel Oasis</title>
    <link rel="stylesheet" href="/css/output.css">
    <link rel="icon" type="image/x-icon" href="/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="og:title" content="Hotel Oasis">
    <meta name="og:description" content="El mejor hotel de la región">
    <meta name="og:image" content="/favicon/android-chrome-512x512.png">
    <meta name="og:url" content="https://hotel-oasis.com">
    <meta name="og:site_name" content="Hotel Oasis">
      <?= $_ENV['DEV_MODE'] == 'true' || getenv('DEV_MODE', 'false') === 'true'
      	? '<meta http-equiv="refresh" content="5">'
      	: '' ?>
  </head>
  
  <body class="h-full">
    <div class="min-h-full">