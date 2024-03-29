@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('trip/view') }}">Trips</a></li>
      <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
  </nav>

  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
  </div>
  @endif
  
  @if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Warning!</strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h6 class="card-title">Trips List</h6>
            </div>
            @can('Add Trip')
              <div class="col-md-6">
                <a href="{{ url('trip/add') }}" type="button" class="btn btn-primary" style="float:right;">Add Trip</a>
              </div>
            @endcan
          </div>
          <div class="table-responsive pt-3">
            <table id="dataTableExample" class="table table-hover">
              <thead>
                <tr>
                  <th>
                    #
                  </th>
                  <th>
                    Vehicle
                  </th>
                  <th>
                    Route
                  </th>
                  @if (!\Auth::user()->hasRole('Driver'))
                  <th>
                    Driver
                  </th>
                  <th>
                    Nature
                  </th>
                  @endif
                  <th>
                    Date
                  </th>
                  @if (!\Auth::user()->hasRole('Driver'))
                  <th>
                    Rate
                  </th>
                  @endif
                  <th class="text-center align-middle">
                    Status
                  </th>
                  <th class="text-center" data-orderable="false">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($trips as $serial => $trip)
                <tr @if ($trip->notify_complete == '1' || $trip->notify_start == '1') style="background-color:#101920;" @endif>
                  <td>{{ $serial + 1 }}</td>
                  <td>{{ $trip->vehicle->name }}</td>
                  <td>{{ $trip->route->name }}</td>
                  @if (!\Auth::user()->hasRole('Driver'))
                    <td>{{ $trip->vehicle->driver->name }}</td>
                    <td>{{ $trip->vehicle->type }}</td>
                  @endif
                    <td>{{ \Carbon\Carbon::parse($trip->date)->format('d M Y') }}</td>
                  @if (!\Auth::user()->hasRole('Driver'))
                    <td>Rs {{ number_format($trip->rate, 2) }}</td>
                  @endif
                  <td class="text-center align-middle">

                    <!-- In Queue Status -->
                    @if($trip->status == 'In Queue')
                    <h5><span class="badge badge-danger" data-toggle="modal" data-target="#startModal{{$serial}}">{{ $trip->status }}</span></h5>
                    @can('Edit Trip Status')
                      <div class="modal fade text-left" id="startModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              Mark this Trip as Started?
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                              <a href="{{ url('trip/start/'.encrypt($trip->id)) }}" type="button" class="btn btn-primary">Yes</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endcan
                      
                    <!-- Started Status -->
                    @elseif($trip->status == 'Started')
                      <h5><span class="badge badge-primary" data-toggle="modal" data-target="#completeModal{{$serial}}">{{ $trip->status }}</span></h5>
                      @can('Edit Trip Status')
                      <div class="modal fade text-left" id="completeModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              Mark this Trip as Complete?
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                              <a href="{{ url('trip/complete/'.encrypt($trip->id)) }}" type="button" class="btn btn-primary">Yes</a>
                            </div>
                          </div>
                        </div>
                      </div>  
                      @endcan
  
                    <!-- Complete Status -->
                    @elseif($trip->status == 'Completed')
                    <h5><span class="badge badge-success">{{ $trip->status }}</span></h5>                  
                    @endif
                  </td>

                  <td class="text-center">
                      <!-- Edit Trip-->
                      @can('Edit Trip')
                        <a title="Edit" @if ($trip->status == 'Completed' || $trip->status == 'Started') style="pointer-events: none;" @endif href="{{ url('trip/edit/'.encrypt($trip->id)) }}">
                          <button @if ($trip->status == 'Completed' || $trip->status == 'Started') disabled @endif type="button" class="btn btn-primary btn-icon">
                            <i data-feather="edit"></i>
                          </button>
                        </a>
                      @endcan
                      <!-- Delete Trip-->
                      @can('Delete Trip')
                        <a title="Delete" data-toggle="modal" @if ($trip->status == 'Started') style="pointer-events: none;" @endif data-target="#actionModal{{$serial}}">
                          <button @if ($trip->status == 'Started') disabled @endif type="button" class="btn btn-primary btn-icon">
                            <i data-feather="trash-2"></i>
                          </button>
                        </a>
                        <div class="modal fade text-left" id="actionModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to delete this trip?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="{{ url('trip/destroy/'.encrypt($trip->id)) }}" type="button" class="btn btn-primary">Yes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endcan
                      <!-- Acknowledge Trip-->
                      @can('Acknowledge Trip')
                      @if ($trip->notify_complete == '1' || $trip->notify_start == '1')
                        <a title="Acknowledge" href="{{ url('trip/acknowledge/'.encrypt($trip->id)) }}">
                          <button type="button" class="btn btn-primary btn-icon">
                            <i data-feather="eye-off"></i>
                          </button>
                        </a>
                      @endif
                      @endcan
                      <!-- Current GPS Coordinates-->
                      @can('GPS Coordinates Trip')
                        <a title="GPS Coordinates" @if ($trip->status == 'In Queue' || $trip->status == 'Completed') style="pointer-events: none;" @endif  href="{{ url('/trip/gps/coordinates/'.encrypt($trip->id)) }}">
                          <button @if ($trip->status == 'In Queue' || $trip->status == 'Completed') disabled @endif type="button" class="btn btn-primary btn-icon">
                            <i data-feather="compass"></i>
                          </button>
                        </a>
                      @endcan
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush