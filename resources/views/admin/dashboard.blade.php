@extends('admin.layout')

@section('content')
<div class="container">
  <h1 class="mb-4">Bienvenido - ConfiaSalud</h1>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card card-admin">
        <div class="card-admin-header">Especialistas</div>
        <div class="card-body">
          <p>Gestiona tus especialistas.</p>
          <a href="{{ route('especialistas.index') }}" class="btn btn-outline-dark">Ver listado</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-admin">
        <div class="card-admin-header">Áreas</div>
        <div class="card-body">
          <p>Gestiona tus áreas.</p>
          <a href="{{ route('areas.index') }}" class="btn btn-outline-dark">Ver listado</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-admin">
        <div class="card-admin-header">Horarios</div>
        <div class="card-body">
          <p>Gestiona horarios de especialistas.</p>
          <a href="{{ route('horarios.index') }}" class="btn btn-outline-dark">Ver listado</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
