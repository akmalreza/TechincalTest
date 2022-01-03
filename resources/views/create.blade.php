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
          <div class="col-12" id="form-wrapper">
            <form action="" method="POST" id="create-form">
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
              <div class="col-12 my-2">
                <label for="input-email">Email</label>
                <input type="email" class="col-12" id="input-email" name="email" value="">
              </div>
              <div class="col-12 my-2">
                <label for="input-password">Password</label>
                <input type="password" class="col-12" id="input-password" name="password" value="">
              </div>
              <div class="col-12 my-2 text-right">
                <button class="btn btn-success" type="button" onclick="submitForm()">Submit</button>
                <a class="btn btn-default" href="{{ route('index') }}">Cancel</a>
              </div>
            </form>
          </div>
          <div id="loading-state" class="col-12 text-center d-none">
            Loading
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
      // Switch to render loading state and hide form
      document.getElementById('loading-state').classList.remove('d-none');
      document.getElementById('form-wrapper').classList.add('d-none');

      // Hit ajax to store user's data
      axios.post(`{{ route('store') }}`, new FormData(document.getElementById('create-form')))
      .then(res => {
        // If data response's status is 'error' then show the message
        if (res.data.status === 'error') {
          alert(res.data.message);
        } else {
          // Redirect back to landing page if there is no error returned
          window.location.assign(`{{ route('index') }}`);
        }
      })
      .catch(error => {
        // Generalize all other error
        alert('Error');
      })
      .finally(() => {
        // Switch to render form and hide the loading state element
        document.getElementById('form-wrapper').classList.remove('d-none');
        document.getElementById('loading-state').classList.add('d-none');
      })
    }
  </script>
@endsection
