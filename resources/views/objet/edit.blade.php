@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }

    .form-title {
        text-align: center;
        color: #2d3748;
        margin-bottom: 30px;
        font-size: 1.8rem;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 1.8rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #4a5568;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.2s;
        background-color: #f8fafc;
    }

    .form-input:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        background-color: white;
        outline: none;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234a5568' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
    }

    .file-upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background-color: #f8fafc;
        margin-bottom: 10px;
    }
    
    .file-upload-area:hover {
        border-color: #4299e1;
        background-color: #ebf4ff;
    }
    
    .upload-instructions {
        color: #4a5568;
    }
    
    .browse-link {
        color: #4299e1;
        text-decoration: underline;
        font-weight: 500;
    }
    
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }
    
    .preview-item {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #e53e3e;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
    }
    
    .form-submit {
        width: 100%;
        padding: 12px;
        background-color: #4299e1;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .form-submit:hover {
        background-color: #3182ce;
    }

    .text-muted {
        font-size: 0.85rem;
        color: #718096;
        margin-top: 0.3rem;
        display: block;
    }

    .btn-secondary {
        display: inline-block;
        margin-top: 15px;
        padding: 12px 20px;
        background-color: #e2e8f0;
        color: #4a5568;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .btn-secondary:hover {
        background-color: #cbd5e0;
        color: #2d3748;
    }

    .error-message {
        color: #e53e3e;
        font-size: 0.85rem;
        margin-top: 5px;
    }
</style>

<div class="form-container">
    <h1 class="form-title">Modifier l'objet</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('objet.update', $objet->id) }}" enctype="multipart/form-data" id="edit-object-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom" class="form-label">Nom de l'objet</label>
            <input type="text" id="nom" name="nom" class="form-input" 
                   value="{{ old('nom', $objet->nom) }}" required placeholder="Ex: Perceuse électrique">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-input form-textarea" required 
                      placeholder="Décrivez votre objet en détail...">{{ old('description', $objet->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" id="ville" name="ville" class="form-input" 
                   value="{{ old('ville', $objet->ville) }}" required placeholder="Ex: Paris">
        </div>

        <div class="form-group">
            <label for="prix_journalier" class="form-label">Prix journalier (€)</label>
            <input type="number" id="prix_journalier" name="prix_journalier" 
                   class="form-input" step="0.01" value="{{ old('prix_journalier', $objet->prix_journalier) }}" 
                   required placeholder="Ex: 9.99">
        </div>

        <div class="form-group">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select id="categorie_id" name="categorie_id" class="form-input form-select" required>
                <option value="">-- Sélectionner une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ $objet->categorie_id == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="etat" class="form-label">État</label>
            <select id="etat" name="etat" class="form-input form-select" required>
                <option value="neuf" {{ $objet->etat == 'neuf' ? 'selected' : '' }}>Neuf</option>
                <option value="bon" {{ $objet->etat == 'bon' ? 'selected' : '' }}>Bon état</option>
                <option value="usé" {{ $objet->etat == 'usé' ? 'selected' : '' }}>Usé</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Images de l'objet (1-3 max)</label>
            
            <!-- Zone de dépôt -->
            <div class="file-upload-area" onclick="document.getElementById('images').click()">
                <div class="upload-instructions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4299e1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    <p>Glissez-déposez vos images ici ou <span class="browse-link">parcourir</span></p>
                    <small class="text-muted">Formats acceptés : JPEG, PNG (max 2MB par image)</small>
                </div>
            </div>
            
            <!-- Input fichier caché -->
            <input type="file" id="images" name="images[]" multiple 
                   accept="image/jpeg,image/png" style="display: none;">
            
            <!-- Prévisualisation des images existantes -->
            @if($objet->images->isNotEmpty())
                <div class="mt-3">
                    <h6>Images actuelles :</h6>
                    <div class="image-preview-container" id="existing-images-container">
                        @foreach($objet->images as $image)
                            <div class="preview-item">
                                <img src="{{ asset($image->url) }}" alt="Image de l'objet">
                                <button type="button" class="remove-btn" 
                                        onclick="toggleImageKeep(this, '{{ $image->id }}')">×</button>
                                <input type="hidden" name="keep_images[]" value="{{ $image->id }}" class="keep-image-input">
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Cliquez sur × pour supprimer une image</small>
                </div>
            @endif
            
            <!-- Prévisualisation des nouvelles images -->
            <div class="image-preview-container mt-3" id="new-images-container" style="display: none;">
                <h6>Nouvelles images :</h6>
            </div>

            <!-- Message d'erreur pour le nombre d'images -->
            <div id="image-error" class="error-message" style="display: none;"></div>
        </div>

        <button type="submit" class="form-submit">Mettre à jour</button>
        <a href="{{ route('objet.mes_objets') }}" class="btn-secondary">Annuler</a>
    </form>
</div>
<script>
// Script pour gérer l'upload d'images
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('images');
    const dropZone = document.querySelector('.file-upload-area');
    const newImagesContainer = document.getElementById('new-images-container');
    
    // Gestion du drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropZone.style.borderColor = '#4299e1';
        dropZone.style.backgroundColor = '#ebf4ff';
    }
    
    function unhighlight() {
        dropZone.style.borderColor = '#e2e8f0';
        dropZone.style.backgroundColor = '#f8fafc';
    }
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        handleFiles(files);
    }
    
    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });
    
    function handleFiles(files) {
        newImagesContainer.innerHTML = '<h6>Nouvelles images :</h6>';
        newImagesContainer.style.display = 'block';
        
        Array.from(files).forEach(file => {
            if (!file.type.match('image.*')) return;
            
            const reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.title = theFile.name;
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-btn';
                    removeBtn.innerHTML = '×';
                    removeBtn.onclick = function() {
                        div.remove();
                        if (newImagesContainer.children.length <= 1) {
                            newImagesContainer.style.display = 'none';
                        }
                    };
                    
                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    newImagesContainer.appendChild(div);
                };
            })(file);
            
            reader.readAsDataURL(file);
        });
    }
});

// Fonction pour basculer la conservation d'une image existante
function toggleImageKeep(button, imageId) {
    const previewItem = button.parentElement;
    const input = previewItem.querySelector('.keep-image-input');
    
    if (input) {
        // Si l'input existe, on le supprime (image non conservée)
        input.remove();
        previewItem.style.opacity = '0.5';
        previewItem.style.border = '1px dashed #e53e3e';
        button.textContent = '+';
        button.style.background = '#38a169';
    } else {
        // Sinon on le recrée (image conservée)
        const newInput = document.createElement('input');
        newInput.type = 'hidden';
        newInput.name = 'keep_images[]';
        newInput.value = imageId;
        newInput.className = 'keep-image-input';
        
        previewItem.appendChild(newInput);
        previewItem.style.opacity = '1';
        previewItem.style.border = '1px solid #e2e8f0';
        button.textContent = '×';
        button.style.background = '#e53e3e';
    }
}
</script>
@endsection