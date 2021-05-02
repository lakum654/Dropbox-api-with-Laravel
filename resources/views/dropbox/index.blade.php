<html>
    <title>Dropbox File Read</title>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
       <div class="container">
           <h3 class="text-center">Dropbox API Download & Read</h3>
        <form action="{{ url('dropbox/download') }}" method="POST">
            @csrf()
          <div class="row">
              <div class="col-8">
                <label>Select File From Dropbox Which You Uploaded</label>
                <select name="file" class="form-control">
                    <option>Select File</option>
                    @foreach($files['entries'] as $val)
                       <option value="{{ $val['name'] }}">{{ $val['name'] }}- {{ $val['size'] }} </option>
                    @endforeach
                </select>
              </div>
              <div class="col-4"><br><br>
                 <input type="submit" value="download" class="btn btn-success">
              </div>
          </div>
        </form>
        <br><br>

        <form action="{{ url('dropbox/upload') }}" method="POST" enctype="multipart/form-data"  >
            @csrf()
          <div class="row">
              <div class="col-8">
                <label>Upload File In To Dropbox</label>
               <input type="file" name="file" class="form-control">
              </div>
              <div class="col-4"><br><br>
                 <input type="submit" value="Upload" class="btn btn-success">
              </div>
          </div>
        </form>

        @if(Session::has('file'))
            File Download Successfully <a href="{{ url('dropbox/read/'.Session::get('file')) }}">Read..</a>
        @endif
       </div>
    </body>
</html>