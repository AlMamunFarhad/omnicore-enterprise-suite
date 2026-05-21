@props([
    'type' => 'success',
    'title' => 'Notification',
    'message' => '',
])

<div class="toast toast-{{ $type }} show mb-3" role="alert">

    <div class="toast-header">

        <strong class="me-auto">
            {{ $title }}
        </strong>

        <button type="button" class="btn-close" data-bs-dismiss="toast">
        </button>

    </div>

    <div class="toast-body">
        {{ $message }}
    </div>

</div>
