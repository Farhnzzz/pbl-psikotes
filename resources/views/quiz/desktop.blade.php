@extends('layouts.dashboard')

@section('container-fluid')
    <div class="card">
        <div class="col-12">
            <div class="card w-100 position-relative overflow-hidden mb-0">
                <div class="card-body p-4">
                    <div>
                        <div class="row">
                            <div class="col-12 col-sm-auto mb-2">
                                <ol class="breadcrumb font-size-16 mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="#" class="router-link-active">
                                            <strong class="router-link-active">
                                                <i class="uil uil-home-alt"></i>
                                                PSIKOTES MMPI-2
                                            </strong>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ env('APP_NAME') }}</li>
                                </ol>
                                <p class="text-muted text-truncate mb-0">
                                    <span>Deadline</span>
                                    <strong class="text-dark">{{ \Carbon\Carbon::parse($deadline)->format('d F Y H:i A') }}</strong>
                                </p>
                            </div>
                            <div class="col mb-2">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center mb-0" id="countdown_desc">Waktu Tersisa</h4>
                                    <h4 class="text-center mb-0 ms-2" id="countdown">00:00:00</h4>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-small btn-danger me-2" onclick="finish_confirmation();">
                                        <i class="uil uil-edit me-1"></i>
                                        Selesaikan Ujian
                                    </button>
                                    <button class="btn btn-small btn-success" onclick="window.location.href='{{ route('question.list') }}'">
                                        Daftar Soal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <div class="border-bottom">
                <div class="row">
                    <div class="col-12 col-sm-auto mb-2">
                        <div class="d-flex justify-content-center">
                            <h3 class="text-truncate mb-2 btn btn-lg btn-outline-dark">
                                <span>No</span>
                                <strong class="text-dark" id="no_question">{{ $last_question->id }}</strong>
                                <span>dari</span>
                                <strong class="text-dark">567</strong>
                                <span>soal</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-4 mt-0">
            <div class="row">
                <div class="col-12 mt-0">
                    <div class="d-flex justify-content-center mb-4">
                        <div>
                            <h3 class="text mb-4" id="question">
                                {{ $last_question->content }}
                            </h3>
                        </div>
                    </div>
                    <!-- answer option using button (3 options) and centering -->
                    <!-- make button each line vertically -->
                    <div class="mt-2 d-flex justify-content-center">
                        <div class="col-md-6">
                            <input type="hidden" id="question_id" value="{{ $last_question->id }}">
                            <button class="btn btn-outline-dark btn-lg w-100 mb-2" id="yes_answer" onclick="submit_answer('Yes')">YA</button>
                            <button class="btn btn-outline-dark btn-lg w-100 mb-2" id="unknown_answer" onclick="submit_answer('Unknown')">TIDAK TAHU</button>
                            <button class="btn btn-outline-dark btn-lg w-100 mb-2" id="no_answer" onclick="submit_answer('No')">TIDAK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer border-top p-4">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-dark" onclick="prev_question()">Sebelumnya</button>
                        <button class="btn btn-dark" onclick="next_question()">Selanjutnya</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let deadline_date = new Date('{{ $deadline }}').getTime();
        let x = setInterval(function() {
            let now = new Date().getTime();
            let t = deadline_date - now;
            let hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((t % (1000 * 60)) / 1000);
            document.getElementById("countdown").innerHTML = hours + ":" + minutes + ":" + seconds;
            if (t < 0) {
                clearInterval(x);
                $('#countdown_desc').replaceWith('<h3 class="text-danger">Waktu Habis</h3>');
                $('#countdown').remove();
            }
        }, 1000);
    </script>
    <script>
        function submit_answer(answer) {
            $.ajax({
                url: '{{ route('store_question') }}',
                type: 'POST',
                data: {
                    question_id: $('#question_id').val(),
                    answer: answer,
                    exam_id: '{{ $exam->id }}'
                },
                success: function(response) {
                    if(response.question_id !== 567) {
                        get_question(response.question_id, 1);
                    }else{
                        $.ajax({
                            url: '{{ route('submit_exam') }}',
                            type: 'POST',
                            success: function(response) {
                                swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: 'Ujian telah selesai'
                                }).then((result) => {
                                    window.location = '{{ route('examHistory') }}';
                                });
                            },
                            error: function(error) {
                                swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: error.responseJSON.message
                                });
                            }
                        });
                    }
                },
                error: function(error) {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.responseJSON.message
                    });
                }
            });
        }

        function get_question(question_id, index) {
            question_id = parseInt(question_id);
            index = parseInt(index);
            let next_question_id = question_id + index;
            $.ajax({
                url: '{{ url('/api/question') }}' + '/' + next_question_id,
                type: 'GET',
                success: function(response) {
                    if (response.question){
                        $('#question').html(response.question.content);
                        $('#no_question').html(response.question.id);
                        $('#question_id').val(response.question.id);
                        if(response.answer){
                            switch (response.answer.answer) {
                                case 1:
                                    $('#yes_answer').addClass('active');
                                    $('#unknown_answer').removeClass('active');
                                    $('#no_answer').removeClass('active');
                                    break;
                                case null:
                                    $('#yes_answer').removeClass('active');
                                    $('#unknown_answer').addClass('active');
                                    $('#no_answer').removeClass('active');
                                    break;
                                case 0:
                                    $('#yes_answer').removeClass('active');
                                    $('#unknown_answer').removeClass('active');
                                    $('#no_answer').addClass('active');
                                    break;
                            }
                        }else{
                            // clear active class
                            $('#yes_answer').removeClass('active');
                            $('#unknown_answer').removeClass('active');
                            $('#no_answer').removeClass('active');
                        }
                    }else{
                        swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Soal tidak ditemukan atau soal sudah melebihi batas (567 soal)'
                        });
                    }
                },
                error: function(error) {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.responseJSON.message
                    });
                }
            });
        }

        function next_question() {
            let current_question_id = $('#question_id').val();
            get_question(current_question_id, 1);
        }

        function prev_question() {
            let current_question_id = $('#question_id').val();
            get_question(current_question_id, -1);
        }

        function finish_exam(){
            $.ajax(
                {
                    url: '{{ route('submit_exam') }}',
                    type: 'POST',
                    data: {},
                    success: function (data) {
                        swal.fire({
                            title: 'Ujian telah selesai',
                            text: 'Ujian telah selesai, silahkan tunggu hasil interpretasi dari dokter.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('exam.result', $exam->id) }}';
                            }
                        });
                    },
                    error: function (data) {
                        swal.fire({
                            title: 'Gagal',
                            text: 'Gagal menyelesaikan ujian, : ' + data.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            );
        }

        function finish_confirmation(){
            swal.fire({
                title: 'Selesaikan Ujian?',
                text: 'Pastikan Anda sudah menjawab semua soal dan batas maksimal tidak menjawab pertanyaan adalah 30 soal, lebih dari itu psiotes akan dianggap tidak valid.',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Ya, Selesaikan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                    if (result.isConfirmed) {
                        finish_exam();
                    }
                }
            );
        }

        @if($exam->answer)
            get_question({{ $last_question->id }}, 0);
        @endif
    </script>
@endsection
