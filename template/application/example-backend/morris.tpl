<!DOCTYPE html>
<html lang="{$__view.lang_iso2}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
{$__view.meta}

  <title>{$__view.title}</title>

  <!-- Core CSS - Include with every page -->
  <link href="/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/lib/font-awesome/css/font-awesome.css" rel="stylesheet">

  <!-- Page-Level Plugin CSS - Morris -->
  <link href="/module/application/backend/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

  <!-- SB Admin CSS - Include with every page -->
  <link href="/module/application/backend/css/sb-admin.css" rel="stylesheet">
{$__view.links}

  <script type="text/javascript" src="/lib/jquery.min.js"></script>
  <!-- Add custom JS here -->
{$__view.scripts}

</head>

<body>

    <div id="wrapper">

        {widgets area="navbar_admin"}

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Morris.js Charts</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Area Chart Example
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Bar Chart Example
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-bar-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Line Chart Example
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-line-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Donut Chart Example
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Morris.js Usage
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <p>Morris.js is a jQuery based charting plugin created by Olly Smith. In SB Admin, we are using the most recent version of Morris.js which includes the resize function, which makes the charts fully responsive. The documentation for Morris.js is available on their website, <a target="_blank" href="http://www.oesmith.co.uk/morris.js/">http://www.oesmith.co.uk/morris.js/</a>.</p>
                            <a target="_blank" class="btn btn-default btn-lg btn-block" href="http://www.oesmith.co.uk/morris.js/">View Morris.js Documentation</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
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
  <script src="/module/application/backend/js/plugins/morris/raphael-2.1.0.min.js"></script>
  <script src="/module/application/backend/js/plugins/morris/morris.js"></script>
  <!-- Validation Plugin -->
  <script type="text/javascript" src="/lib/validation/dist/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/lib/validation/dist/additional-methods.min.js"></script>
  {if $__view.lang_iso2!='en'}
  <script type="text/javascript" src="/lib/validation/dist/localization/messages_{$__view.lang_iso2}.js"></script>
  {/if}

  <!-- Page-Level Demo Scripts - Morris - Use for reference -->
  <script src="/module/application/backend/js/demo/morris-demo.js"></script>

  <!-- Page-Level Scripts -->
{$__view.scripts}

</body>
</html>
