<div class="offcanvas offcanvas-end" tabindex="-1" id="ocNewRecord" aria-labelledby="ocNewRecord">
    <div class="offcanvas-header">
        <div class="border-bottom mb-4">
            <h5 class="text-muted text-center space-1">Registrar entrada/saída</h5>
        </div>
        <button type="button" class="btn-close text-reset float-right" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="POST" action="./include/cFinance.php" id="formRegister" >
            <div class="form-group">
                <small> <b> Repetição</b> </small>
                <select class="form-control select2" name="recurrent" onchange='recurrenceOptions(this.value)'>
                    <option value="u">Única</option>
                    <option value="f">Fixa</option>
                </select>
            </div>

            <div id='divBodyFinance'>
            </div>

            <div class="text-center">
                <button class="btn w-100 btn-success space-1">Registrar</button>
            </div>
        </form>
    </div>
    <div class="offcanvas-footer mr-2">
        <?php include_once '../include/footer.php' ?>
    </div>
</div>