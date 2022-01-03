@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          User Data
          <div>
            <a class="btn btn-primary btn-sm" href="{{ route('create') }}">Create</a>
          </div>
        </div>
        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $index => $row)
                <tr>
                  <th scope="row" class="align-middle">{{ $index + 1 }}</th>
                  <td class="align-middle">{{ $row->name }}</td>
                  <td class="align-middle">{{ $row->status }}</td>
                  <td class="align-middle">{{ $row->position }}</td>
                  <td class="align-middle d-flex gap-1">
                    <form action="{{ route('edit') }}" method="POST">
                      @csrf
                      <input type="hidden" name="id" value="{{ $row->user_id }}">
                      <button class="btn btn-warning btn-sm" type="submit">Edit</button>
                    </form>
                    <button class="btn btn-danger btn-sm" onclick="deleteUser(`{{ $row->user_id }}`)">Delete</button>
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
@section('script')
  <script>
    function deleteUser(user_id) {
      // Hit ajax for deleting user
      axios.post(`{{ route('delete') }}`, {user_id})
      .then(res => {
        // Reload the page to re-render because the table is not using JavaScript framework
        window.location.reload();
      })
      .catch(error => {
        // Alert generalize all error
        alert('Error');
      });
    }
  </script>
@endsection
