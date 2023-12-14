<div class="modal fade" id="novoDependenteModal" tabindex="-1" role="dialog" aria-labelledby="novoDependenteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novoDependenteModalLabel">Novo Dependente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <?php echo '<form action="client_details.php?id=' . $id . '" method="post">'; ?>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="parentesco">Parentesco:</label>
                    <select class="form-control" name="parentesco" required>
                        <option value="CONJUGE">CONJUGE</option>
                        <option value="FILHO(A)">FILHO(A)</option>
                        <option value="ENTEADO(A)">ENTEADO(A)</option>
                        <option value="PAI">PAI</option>
                        <option value="MÃE">MÃE</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>