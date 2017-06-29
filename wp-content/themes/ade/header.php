<?
/**
 * @author      Flurin Dürst
 * @version     1.3
 * @since       WPSeed 0.1
 */
?>
<!DOCTYPE html>
<html <? language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=1, user-scalable=no">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <!--===== OPEN-GRAPH TAGS =====-->
    <meta property="og:title" content="<? bloginfo('name'); ?>">
    <meta property="og:description" content="<? bloginfo('description'); ?>">
    <meta property="og:url" content="<? bloginfo('url'); ?>">
    <meta property="og:image" content="<? bloginfo('template_url') ?>/dist/images/ogimg.jpg">
    <meta property="og:image:width" content="">
    <meta property="og:image:height" content="">
    <? wp_head(); ?>
  </head>

  <body>
      <!-- outer most container -->
      <div class="wrapper">
        <header>
          <nav id="header" class="container">
            <div id="logo"><a href=""></a></div>
            <nav class="top-nav"></div>
          </nav>
        </header>
        <div class="container main row">
        <div class="left-sidebar col-md-3">
          <?php require get_template_directory() . '/inc/sidebar.php'; ?>
        </div>
        <div class="main-content col-md-9">
