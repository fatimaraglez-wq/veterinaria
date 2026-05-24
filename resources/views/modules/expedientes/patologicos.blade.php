@extends('layouts.app')

@section('titulo_pagina', 'Patológicos')

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-disease mr-2 text-info"></i> Antecedentes Patológicos: <span class="text-primary">{{ $mascota->nombre }}</span>
        </h1>
        <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Regresar a Expediente
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-disease mr-2"></i>Registro Patológico
                    </h6>
                    <span class="badge badge-primary px-3 py-2" style="font-size: 0.9rem;">
                        Registro General
                    </span>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('expedientes.mascotas.patologicos.update', $mascota->id) }}" method="POST" id="form-patologicos">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-gray-700" style="font-size: 1.1rem;">Descripción de enfermedades previas o crónicas:</label>
                            
                            {{-- Quill Editor Container --}}
                            <div id="editor-container" style="height: 300px; font-size: 1.1rem;">
                                {!! old('patologicos', $mascota->patologicos) !!}
                            </div>
                            
                            {{-- Hidden input to store Quill content for form submission --}}
                            <input type="hidden" id="patologicos" name="patologicos" value="{{ old('patologicos', $mascota->patologicos) }}">
                        </div>
                        
                        <div class="mt-4 text-right">
                            <button type="submit" class="btn btn-success shadow-sm btn-lg px-5">
                                <i class="fas fa-save mr-2"></i> Guardar Antecedentes
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <!-- Quill Snow Theme -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #3a3b45;
        }
    </style>
@endpush

@push('scripts')
    <!-- Quill Library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Quill editor
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Describa las enfermedades que ha padecido la mascota...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['clean']
                    ]
                }
            });

            // Sync Quill content to hidden input before form submit
            var form = document.getElementById('form-patologicos');
            var hiddenInput = document.getElementById('patologicos');

            form.onsubmit = function() {
                // Get HTML content from Quill
                var htmlContent = quill.root.innerHTML;
                
                // If it's just an empty paragraph, consider it empty
                if (htmlContent === '<p><br></p>') {
                    hiddenInput.value = '';
                } else {
                    hiddenInput.value = htmlContent;
                }
            };
        });
    </script>
@endpush
