<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Full Width Page - Modern Business - Start Bootstrap Template</title>

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
          <h1 class="page-header">404 <small>Page Not Found</small></h1>
          <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">404</li>
          </ol>
        </div>

      </div>

      <div class="row">

        <div class="col-lg-12">
          <p class="error-404">404</p>
          <p class="lead">The page you're looking for could not be found.</p>
          <p>Here are some helpful links to help you find what you're looking for:</p>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Other</a></li>
          </ul>
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