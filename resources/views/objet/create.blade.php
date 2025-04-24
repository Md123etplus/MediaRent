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

    .form-file {
        padding: 10px;
        background: white;
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

    .form-hint {
        font-size: 0.85rem;
        color: #718096;
        margin-top: 0.3rem;
        display: block;
    }

     /* Styles pour la zone d'upload */
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
    
    /* Prévisualisation des images */
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
    
    /* Message d'erreur */
    .upload-error {
        color: #e53e3e;
        font-size: 0.85rem;
        margin-top: 5px;
    }
</style>

<div class="form-container">
    <h1 class="form-title">Ajouter un nouvel objet</h1>

    <form method="POST" action="{{ route('objet.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="nom" class="form-label">Nom de l'objet</label>
            <input type="text" name="nom" class="form-input" required placeholder="Ex: Perceuse électrique">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-input form-textarea" required placeholder="Décrivez votre objet en détail..."></textarea>
        </div>

        <div class="form-group">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" name="ville" class="form-input" required placeholder="Ex: Paris">
        </div>

        <div class="form-group">
            <label for="prix_journalier" class="form-label">Prix journalier (€)</label>
            <input type="number" name="prix_journalier" class="form-input" step="0.01" required placeholder="Ex: 9.99">
        </div>

        <div class="form-group">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select name="categorie_id" class="form-input form-select" required>
                <option value="">-- Sélectionner une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="etat" class="form-label">État de disponibilité</label>
            <select name="etat" class="form-input form-select" required>
                <option value="dispo">dispo</option>
                <option value="indispo">indispo</option>
            </select>
        </div>

        <div class="form-group">
    <label class="form-label">Images de l'objet (1-3 max)</label>
    
    <!-- Input principal pour les fichiers -->
    <input type="file" 
           id="image-upload" 
           name="images[]" 
           class="form-input form-file" 
           accept="image/jpeg,image/png" 
           multiple 
           required
           style="display: none;">
    
    <!-- Zone de dépôt et bouton personnalisé -->
    <div class="file-upload-area" id="drop-zone">
        <div class="upload-instructions">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4299e1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            <p>Glissez-déposez vos images ici ou <span class="browse-link">parcourir</span></p>
            <small class="form-hint">Formats acceptés : JPEG, PNG (max 2MB par image)</small>
        </div>
    </div>
    
    <!-- Prévisualisation des images -->
    <div class="image-preview-container" id="image-preview"></div>
    
    <!-- Message d'erreur -->
    <div class="upload-error" id="upload-error" style="display: none;"></div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('image-upload');
    const dropZone = document.getElementById('drop-zone');
    const previewContainer = document.getElementById('image-preview');
    const errorDisplay = document.getElementById('upload-error');
    const maxFiles = 3;
    let uploadedFiles = [];
    
    // Gestion du clic sur la zone
    dropZone.addEventListener('click', () => fileInput.click());
    
    // Gestion du changement de fichiers
    fileInput.addEventListener('change', handleFiles);
    
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
        handleFiles({ target: fileInput });
    }
    
    function handleFiles(e) {
        errorDisplay.style.display = 'none';
        const files = Array.from(e.target.files);
        
        // Vérification du nombre de fichiers
        if (uploadedFiles.length + files.length > maxFiles) {
            showError(`Vous ne pouvez uploader que ${maxFiles} images maximum.`);
            return;
        }
        
        files.forEach(file => {
            // Vérification du type et taille
            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                showError(`Le format ${file.type} n'est pas supporté. Utilisez JPEG ou PNG.`);
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) {
                showError(`L'image ${file.name} dépasse 2MB.`);
                return;
            }
            
            // Ajout du fichier
            uploadedFiles.push(file);
            createPreview(file);
        });
        
        // Mise à jour de l'input
        updateFileInput();
    }
    
    function createPreview(file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = file.name;
            
            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = '×';
            removeBtn.onclick = () => removePreview(previewItem, file);
            
            previewItem.appendChild(img);
            previewItem.appendChild(removeBtn);
            previewContainer.appendChild(previewItem);
        };
        
        reader.readAsDataURL(file);
    }
    
    function removePreview(previewElement, file) {
        previewElement.remove();
        uploadedFiles = uploadedFiles.filter(f => f !== file);
        updateFileInput();
    }
    
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
    
    function showError(message) {
        errorDisplay.textContent = message;
        errorDisplay.style.display = 'block';
    }
    
    // Validation avant soumission
    document.querySelector('form').addEventListener('submit', function(e) {
        if (uploadedFiles.length < 1) {
            e.preventDefault();
            showError('Veuillez ajouter au moins une image.');
        }
    });
});
</script>

        <button type="submit" class="form-submit">Créer l'objet</button>
    </form>
</div>
@endsection