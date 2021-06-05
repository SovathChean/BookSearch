@extends('layouts.app')

@section('content')

<div class="row justify-content-center p-3">
  <div class="col-12 col-md-10 col-lg-8">
    <form class="card card-sm">
      <div class="card-body row no-gutters align-items-center">
        <div class="col-auto">
          <i class="fas fa-search h4 text-body"></i>
        </div>
        <!--end of col-->
        <div class="col">
          <input class="form-control form-control-lg form-control-borderless" type="search"
            placeholder="Search topics or keywords">
        </div>
        <!--end of col-->
        <div class="col-auto">
          <button class="btn btn-lg btn-success" type="submit">Search</button>
        </div>
        <!--end of col-->
      </div>
    </form>
  </div>
  <!--end of col-->
</div>
<div class="d-flex justify-content-center">
  <div class="col-md-10 p-3">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Author Name</th>
          <th>Book Title</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>John Doe</td>
          <td>Never Split the Difference: Negotiating As If Your Life Depended On It</td>
          <td>Hailed as one of the best modern books on the art of negotiation, Never Split the Difference is written by
            Chris Voss, a renowned negotiator.
            After serving on the police force in Kansas City, Missouri, and experiencing what the rough streets there
            had to offer, Voss joined the FBI to further his career. He eventually became a hostage negotiator, and in
            this line of work he often came face-to-face with a range of criminals, including bank robbers and
            terrorists.</td>
        </tr>
        <tr>
          <td>Peter Parker</td>
          <td>Shoe Dog: A Memoir by the Creator of Nike</td>
          <td>Hailed as one of the best modern books on the art of negotiation, Never Split the Difference is written by
            Chris Voss, a renowned negotiator.
            After serving on the police force in Kansas City, Missouri, and experiencing what the rough streets there
            had to offer, Voss joined the FBI to further his career. He eventually became a hostage negotiator, and in
            this line of work he often came face-to-face with a range of criminals, including bank robbers and
            terrorists.</td>
        </tr>
        <tr>
          <td>Fran Wilson</td>
          <td>Human Resources</td>
          <td>Hailed as one of the best modern books on the art of negotiation, Never Split the Difference is written by
            Chris Voss, a renowned negotiator.
            After serving on the police force in Kansas City, Missouri, and experiencing what the rough streets there
            had to offer, Voss joined the FBI to further his career. He eventually became a hostage negotiator, and in
            this line of work he often came face-to-face with a range of criminals, including bank robbers and
            terrorists.</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


@endsection
