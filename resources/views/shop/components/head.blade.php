<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width height=device-height initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('shop/images/favicon.ico"')  }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Work+Sans:300,400,500,700%7CZilla+Slab:300,400,500,700,700i%7CGloria+Hallelujah">
    <link rel="stylesheet" href="{{ asset('shop/css/bootstrap.css')  }}">
    <link rel="stylesheet" href="{{ asset('shop/css/fonts.css')  }}">
    <link rel="stylesheet" href="{{ asset('shop/css/style.css')  }}">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=shopping_bag" />


    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
</head>
<body>
<div class="preloader">
    <div class="preloader-logo"><a class="brand" href="index.html">
            <img class="brand-logo-dark" src="{{ asset('shop/images/logo4.png')  }}" alt="" width="245" height="50"/>
            <img class="brand-logo-light" src="{{ asset('shop/images/logo4.png')  }}" alt="" width="245" height="50"/></a>
    </div>
    <div class="preloader-body">
        <div class="cssload-container">
            <div class="cssload-speeding-wheel"></div>
        </div>
    </div>
</div>
<div class="page">
    <div class="bgr-wrap" style="background-image: url('{{ asset('shop/images/Leonardo_fenx.jpg') }}');">
