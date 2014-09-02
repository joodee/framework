<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">{$__view.title} <small>Home Page</small></h1>
    <ol class="breadcrumb">
      <li class="active">Home</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <img class="img-responsive well well-sm" src="http://placehold.it/750x500">
  </div>
  <div class="col-md-4 sidebar-right-home">
    <h3>Object Description</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p>
    <h3>Object Details</h3>
    <ul>
      <li>Lorem Ipsum</li>
      <li>Dolor Sit Amet</li>
      <li>Consectetur</li>
      <li>Adipiscing Elit</li>
    </ul>
  </div>
  {widgets area="sidebar_right"}
</div>
