@extends('layouts.app')

@section('content')

<div class="col-4">
    <div class="card p-2">
        <div class="card-header">
            Погода
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label>
                        Имя
                    </label>
                    <input class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label>
                        Почта
                    </label>
                    <input class="form-control" id="email">
                </div>
                <button type="button" class="btn btn-primary btn-block btn-lg mt-4" data-toggle="modal" data-target="#showModal" id="button">
                    Узнать погоду
                </button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center" id="weather">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
        $(document).ready(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#button").click(function(){
                var name = $('#name').val();
                var email = $('#email').val();
                $.ajax({
                    url: '/weather',
                    type: 'POST',

                    data: {_token: CSRF_TOKEN, name:name, email:email},
                    dataType: 'JSON',

                    success: function (data) {
                        $("#weather").append(data.alert);
                        $("#weather").append(data.message);
                    }
                });
            });
            $(".modal").on("hidden.bs.modal", function(){
                $(".modal-body").html("");
            });
       });
@endsection

@endsection
