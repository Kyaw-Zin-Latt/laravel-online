<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-5">
                <div class="card-body">
                    <form action="{{ route('fruit.store') }}" class="dropzone" id="upload-form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
{{--                            <div class="col">--}}
{{--                                <input type="file" name="photo" class="form-control">--}}
{{--                            </div>--}}
                           <div class="col">
                               <div class="previews"></div>
                           </div>
                            <div class="col">
                                <input type="text" name="name" class="form-control">
                                <p class="text-danger fw-bolder nameError"></p>
                            </div>
                            <div class="col">
                                <input type="number" name="price" class="form-control">
                                <p class="text-danger fw-bolder priceError"></p>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Add fruit</button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>photo</th>
                            <th>Name</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Models\Fruit::all() as $fruit)
                            <tr>
                                <td>{{ $fruit->id }}</td>
                                <td>
                                    <a class="my-link" href="{{ asset('storage/photo/'.$fruit->photo) }}">
                                        <img src="{{ asset('storage/thumbnail/'.$fruit->photo) }}" width="50" alt="image alt"/>
                                    </a>

                                </td>
                                <td>{{ $fruit->name }}</td>
                                <td>{{ $fruit->price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset("js/app.js") }}"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>

    // $("#fruitForm").on("submit",function (e) {
    //     e.preventDefault();
    //
    //     $.post($(this).attr("action"),$(this).serialize(),function (data) {
    //         console.log(data);
    //         if(data.status == "success"){
    //
    //             $data = data.info;
    //
    //             const Toast = Swal.mixin({
    //                 toast: true,
    //                 position: 'top-end',
    //                 showConfirmButton: false,
    //                 timer: 3000,
    //                 timerProgressBar: true,
    //                 didOpen: (toast) => {
    //                     toast.addEventListener('mouseenter', Swal.stopTimer)
    //                     toast.addEventListener('mouseleave', Swal.resumeTimer)
    //                 }
    //             })
    //
    //             Toast.fire({
    //                 icon: 'success',
    //                 title: `${$data.name} is added successfully`
    //             })
    //
    //         }else{
    //
    //             const Toast = Swal.mixin({
    //                 toast: true,
    //                 position: 'top-end',
    //                 showConfirmButton: false,
    //                 timer: 3000,
    //                 timerProgressBar: true,
    //                 didOpen: (toast) => {
    //                     toast.addEventListener('mouseenter', Swal.stopTimer)
    //                     toast.addEventListener('mouseleave', Swal.resumeTimer)
    //                 }
    //             })
    //
    //             Toast.fire({
    //                 icon: 'error',
    //                 title: `${data.message.name}`
    //             })
    //
    //         }
    //     })
    // })

    function successToast($data) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: `${$data.info.name} is added successfully`
        })
    }

    Dropzone.options.uploadForm = { // The camelized version of the ID of the form element

        // The configuration we've talked about above
        autoProcessQueue: false,
        // uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        paramName: 'photo',
        acceptedFiles: ".png,.jpg,.jpeg",
        addRemoveLinks: true,


        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;

            let fruitForm = document.querySelector("#upload-form");
            // First change the button to actually tell Dropzone to process the queue.
            fruitForm.addEventListener("submit", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sending", function(response) {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
                console.log(response);
            });
            this.on("success", function(files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
                console.log(response);
                fruitForm.reset();
                if(response.status == "success") {
                    successToast(response);
                }
            });
            this.on("error", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
                console.log(response);
            });
            this.on("complete", function(file) {
                this.removeFile(file);
            });
        }

    }

    // let fruitForm = document.querySelector("#fruitForm");
    // fruitForm.addEventListener("submit",function (e) {
    //     e.preventDefault();
    //     let formData = new FormData(this);
    //     axios.post(fruitForm.getAttribute('action'),formData).then(function (response) {
    //         console.log(response.data);
    //         if(response.data.status == "success") {
    //             fruitForm.reset();
    //             successToast(response.data);
    //         }
    //     })
    // })

    //venobox

    new VenoBox({
        selector: '.my-link',
        numeration: true,
        infinigall: true,
        share: true,
        spinner: 'rotating-plane'
    });

</script>
</body>
</html>
