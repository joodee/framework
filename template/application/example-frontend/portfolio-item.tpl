<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Single Portfolio Item - Modern Business - Start Bootstrap Template</title>

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

        <div class="col-lg-12">
          <h1 class="page-header">Single Portfolio Item <small>Explain Your Work</small></h1>
          <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Single Portfolio Item</li>
          </ol>
        </div>

      </div>

      <div class="row">

        <div class="col-md-8">
          <img class="img-responsive" src="http://placehold.it/750x500">
        </div>

        <div class="col-md-4">
          <h3>Project Description</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p>
          <h3>Project Details</h3>
          <ul>
            <li>Lorem Ipsum</li>
            <li>Dolor Sit Amet</li>
            <li>Consectetur</li>
            <li>Adipiscing Elit</li>
          </ul>
        </div>

      </div>

      <div class="row">

        <div class="col-lg-12">
          <h3 class="page-header">Related Projects</h3>
        </div>

        <div class="col-sm-3 col-xs-6">
        	<a href="#"><img class="img-responsive img-customer" src="http://placehold.it/500x300"></a>
        </div>

        <div class="col-sm-3 col-xs-6">
        	<a href="#"><img class="img-responsive img-customer" src="http://placehold.it/500x300"></a>
        </div>

        <div class="col-sm-3 col-xs-6">
        	<a href="#"><img class="img-responsive img-customer" src="http://placehold.it/500x300"></a>
        </div>

        <div class="col-sm-3 col-xs-6">
        	<a href="#"><img class="img-responsive img-customer" src="http://placehold.it/500x300"></a>
        </div>

      </div>

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