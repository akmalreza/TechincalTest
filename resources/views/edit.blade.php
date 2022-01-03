@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">User Data</div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <div class="col-12 d-none" id="form-wrapper">
            <form action="" method="POST" id="edit-form">
              <input type="hidden" name="id" value="{{ $data->user_id }}">
              <div class="col-12 my-2">
                <label for="input-name">Name</label>
                <input type="text" class="col-12" id="input-name" name="name" value="">
              </div>
              <div class="col-12 my-2">
                <label for="input-status">Status</label>
                <select type="text" class="col-12" id="input-status" name="status">
                  <option value="" selected disabled>-- Select Option --</option>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div class="col-12 my-2">
                <label for="input-position">Position</label>
                <input type="text" class="col-12" id="input-position" name="position" value="">
              </div>
              <div class="col-12 my-2 text-right">
                <button class="btn btn-success" type="button" onclick="submitForm()">Submit</button>
                <a class="btn btn-default" href="{{ route('index') }}">Cancel</a>
              </div>
            </form>
          </div>
          <div class="col-12 p-5 text-center" id="loading-state">
            <p>Loading Data</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
  <script>
    function submitForm() {

      // Switch render between loading state and form wrapper
      document.getElementById('loading-state').classList.remove('d-none');
      document.getElementById('form-wrapper').classList.add('d-none');

      // Hit ajax to update user data
      // The second parameter is instance from FormData which contain all form input data
      axios.post(`{{ route('update') }}`, new FormData(document.getElementById('edit-form')))
      .then(res => {
        // If data response's status is 'error' then show the message
        if (res.data.status === 'error') {
          alert(res.data.message);
        } else {
          // Reload the page after success updating data
          window.location.reload();
        }
      })
      .catch(error => {
        // Throw and generalize all error
        alert('Error');
      })
      .finally(() => {
        // Switch render back to form and hide loading state
        document.getElementById('form-wrapper').classList.remove('d-none');
        document.getElementById('loading-state').classList.add('d-none');
      });
    }

    // Run ajax to get user's detail after dom content loaded
    document.addEventListener('DOMContentLoaded', function(event) { 
      axios.post(`{{ route('detail') }}`, {user_id: '{{ $data->user_id }}'})
      .then(res => {

        // Assign all data to form input
        document.getElementById('input-name').value = res.data.data.name;
        document.getElementById('input-position').value = res.data.data.position;
        document.getElementById('input-status').value = res.data.data.status;        

        // Switch render to hide loading state and show form
        document.getElementById('form-wrapper').classList.remove('d-none');
        document.getElementById('loading-state').classList.add('d-none');
      })
      .catch(err => {
        // Generalize all error
        alert('Error');
      });
    });
  </script>
@endsection
