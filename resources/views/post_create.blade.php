<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon-32x32.png') }}">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>


</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create Post</h4>
                    </div>
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="">Title</label>
                                <input type="text" name="title" class="form-control">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Upload Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            @foreach($posts as $key => $post)
                <div class="col-8 col-sm-4 col-md-3">
                    <div class="card">
                       <img src="" alt="" title="" />
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <!-- Load FilePond library -->
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    // Register the plugin
    FilePond.registerPlugin(FilePondPluginImagePreview);
    // Get a reference to the file input element
    const inputElement = document.querySelector('input[type="file"]');

    // Create a FilePond instance
    const pond = FilePond.create(inputElement);

    FilePond.setOptions({
    server: {
        process: './temp-upload',
        revert: './temp-delete',
        headers:{
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    }
});
</script>

</body>

</html>
