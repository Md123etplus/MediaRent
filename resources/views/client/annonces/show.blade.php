<form action="{{ route('reservation.store') }}" method="POST">
    @csrf
    <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
    <label>Du : <input type="date" name="date_debut" required></label>
    <label>Au : <input type="date" name="date_fin" required></label>
    <button type="submit" class="btn bg-blue-600 text-white mt-2">Réserver</button>
</form>
