      <title>
      <?php if(isset($page_title)) echo($page_title); else echo SITE_NAME; ?> 
      </title>

    <!-- Meta, title, CSS, favicons, etc. -->

    <!--[if lt IE 9]>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <![endif]-->
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <!--[if ie]>
      <meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" />
      <![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <link rel="alternate" type="application/rss+xml" title="CarDealer RSS Feed" href="../../feed/index.html" />
      <link rel="pingback" href="../../xmlrpc.php" />
      <meta property="og:url"            content="index.html" />
      <meta property="og:title"          content="<?php if(isset($page_title)) echo($page_title); else echo SITE_NAME; ?>" />
      <meta property="og:description"    content="<?php if(isset($page_description)) echo($page_description); else echo SITE_NAME; ?>" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="<?php if(isset($page_description)) echo($page_description); else echo SITE_NAME; ?>">
      

   
    <!-- CSS Global -->
    
        

         <!-- CSS templating -->
    <?php if(isset($css_links)){ foreach($css_links as $key=> $value){ ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url().$value; ?>">
    <?php }} ?>

    
    <!-- Scripts Global -->

        <!-- jQuery -->
        <script src="<?php echo base_url(); ?>assets/vendors/jquery.js" ></script>

    <!-- Scripts templating -->
    <?php if(isset($js_links)){ foreach($js_links as $key=> $value){ ?>
    <script type="text/javascript" src="<?php echo base_url().$value; ?>" ></script>
    <?php }} ?>    

    <!-- pass a tag -->
    <?php if(isset($tag)){ foreach($tag as $key=> $value){
      echo $value;  
     }} ?>
