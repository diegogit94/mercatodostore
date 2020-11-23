<div class="modal fade" id="import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Subir archivo</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('products.import') }}" enctype="multipart/form-data">
                    @csrf
                    <input name="file" accept=".xlsx, .csv" type="file" class="form-control" id="file">
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Importar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
