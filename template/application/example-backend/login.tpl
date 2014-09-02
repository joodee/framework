<!DOCTYPE html>
<html lang="{$__view.lang_iso2}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
{$__view.meta}

  <title>{$__view.title}</title>

  <!-- Core CSS - Include with every page -->
  <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <!-- SB Admin CSS - Include with every page -->
  <link href="/module/application/backend/css/sb-admin.css" rel="stylesheet">
{$__view.links}

  <script type="text/javascript" src="/lib/jquery.min.js"></script>
  <!-- Add custom JS here -->
{$__view.scripts}

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Core Scripts - Include with every page -->
  <script type="text/javascript" src="/lib/jquery.min.js"></script>
  <script src="/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="/module/application/backend/js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <!-- SB Admin Scripts - Include with every page -->
  <script src="/module/application/backend/js/sb-admin.js"></script>
  <!-- Page-Level Plugin Scripts -->
  <!-- Validation Plugin -->
  <script type="text/javascript" src="/lib/validation/dist/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/lib/validation/dist/additional-methods.min.js"></script>
  {if $__view.lang_iso2!='en'}
  <script type="text/javascript" src="/lib/validation/dist/localization/messages_{$__view.lang_iso2}.js"></script>
  {/if}

  <!-- Page-Level Scripts -->
{$__view.scripts}

</body>
</html>
