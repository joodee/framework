<!DOCTYPE html>
<html lang="{$__view.lang_iso2}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
{$__view.meta}

  <title>{$__view.title}</title>

  <!-- Bootstrap core CSS -->
  <link href="/lib/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Add custom CSS here -->
  <link href="/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="/lib/datepicker/css/datepicker.css" rel="stylesheet">
  <link href="/module/application/frontend/css/modern-business.css" rel="stylesheet">
  <link href="/module/application/frontend/css/theme.css" rel="stylesheet">
  <link href="/module/demo/css/demo-home.css" rel="stylesheet">
{$__view.links}

  <script type="text/javascript" src="/lib/jquery.min.js"></script>
</head>

<body>

  {widgets area="navbar_home"}

  <div class="container">
    {Alert::fetchAll()}
    {$controller_output}
    {widgets area="below_controller"}
  </div><!-- /.container -->

  <div class="container">

    <hr>

    <footer>
      <div class="row">
        <div class="col-lg-4">
          <p>Copyright &copy; {$__config.environment.global.company_name} 2012-{'Y'|date}</p>
        </div>
        <div class="col-lg-8">
          {widgets area="footer"}
        </div>
      </div>
    </footer>

  </div><!-- /.container -->

  {widgets area="hidden"}

  <!-- Bootstrap core JavaScript -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="/module/application/frontend/js/modern-business.js"></script>
  <script src="/lib/validation/dist/jquery.validate.min.js"></script>
  <script src="/lib/validation/dist/additional-methods.min.js"></script>
  <script src="/lib/datepicker/js/bootstrap-datepicker.js"></script>
  {if $__view.lang_iso2!='en'}
  <script src="/lib/validation/dist/localization/messages_{$__view.lang_iso2}.min.js"></script>
  {/if}
  <!-- Add custom JS here -->
  {$__view.scripts}
  <script type="text/javascript" src="/module/application/frontend/js/application.js"></script>
</body>
</html>