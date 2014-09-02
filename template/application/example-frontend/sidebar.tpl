<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sidebar Page - Modern Business - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="/lib/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="/module/application/frontend/css/modern-business.css" rel="stylesheet">
    <link href="/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>

    {widgets area="navbar_home_example"}

    <div class="container">
      
      <div class="row">
        <div class="col-md-3 col-sm-4 sidebar">
            <ul class="nav nav-stacked nav-pills">
              <li><a href="/">Home</a></li>
              <li><a href="/example/about/">About</a></li>
              <li><a href="/example/services/">Services</a></li>
              <li><a href="/example/contact/">Contact</a></li>
              <li class="disabled"><a href="#">Portfolio</a></li>
              <li><a href="/example/portfolio-1-col/">1 Column Portfolio</a></li>
              <li><a href="/example/portfolio-2-col/">2 Column Portfolio</a></li>
              <li><a href="/example/portfolio-3-col/">3 Column Portfolio</a></li>
              <li><a href="/example/portfolio-4-col/">4 Column Portfolio</a></li>
              <li><a href="/example/portfolio-item/">Single Portfolio Item</a></li>
              <li class="disabled"><a href="#">Blog</a></li>
              <li><a href="/example/blog-home-1/">Blog Home 1</a></li>
              <li><a href="/example/blog-home-2/">Blog Home 2</a></li>
              <li><a href="/example/blog-post/">Blog Post</a></li>
              <li class="disabled"><a href="#">Blog</a></li>
              <li><a href="/example/full-width/">Full Width Page</a></li>
              <li class="active"><a href="/example/sidebar/">Sidebar Page</a></li>
              <li><a href="/example/faq/">FAQ</a></li>
              <li><a href="/example/404/">404</a></li>
              <li><a href="/example/pricing/">Pricing Table</a></li>
            </ul>
        </div>
      
        <div class="col-md-9 col-sm-8">
          <h1 class="page-header">Sidebar Page <small>For Deeper Customization</small></h1>
          <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Full Width Page</li>
          </ol>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat diam quis nisl vestibulum dignissim. In hac habitasse platea dictumst. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam placerat nunc ut tellus tristique, non posuere neque iaculis. Fusce aliquet dui ut felis rhoncus, vitae molestie mauris auctor. Donec pellentesque feugiat leo a adipiscing. Pellentesque quis tristique eros, sed rutrum mauris.</p>
        </div>

      </div><!-- /.row -->

    </div><!-- /.container -->

    <div class="container">

      <hr>

      <footer>
        <div class="row">
          <div class="col-lg-12">
            <p>Copyright &copy; {$__config.environment.global.company_name} 2012-{'Y'|date}</p>
          </div>
        </div>
      </footer>

    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/lib/jquery.min.js"></script>
    <script src="/lib/bootstrap/js/bootstrap.js"></script>
    <script src="/module/application/frontend/js/modern-business.js"></script>
  </body>
</html>