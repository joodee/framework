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

  <!-- Page-Level Plugin CSS - Blank -->

  <!-- SB Admin CSS - Include with every page -->
  <link href="/module/application/backend/css/sb-admin.css" rel="stylesheet">
{$__view.links}

</head>

<body>

    <div id="wrapper">

        {widgets area="navbar_admin"}

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Blank</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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
