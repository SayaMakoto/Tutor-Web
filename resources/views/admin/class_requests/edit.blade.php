<form action="{{ route('admin.class-requests.update', $classRequest->id) }}" method="POST">
    @csrf
    @method('PUT')

    <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">

        @foreach (\App\Models\ClassRequest::statusOptions() as $key => $label)
            <option value="{{ $key }}" 
                {{ $classRequest->status == $key ? 'selected' : '' }}
                {{ in_array($key, ['assigned', 'cancelled']) ? 'disabled' : '' }}>
                {{ $label }}
            </option>
        @endforeach

    </select>
</form>
