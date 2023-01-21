<div class="modal fade" id="cheque">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="text-primary">
                            <i class="fa fa-history"></i>
                            Cheque no. 101
                        </h4>
                    </div>
                    <div class="col-sm-6">
                        <span class="float-right">
                            <p>Balance Due:</p>
                            <h6 class="text-dark">
                                <b> Ksh. 1000</b>
                                </strong>
                        </span>
                    </div>
                </div>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="">Payee</label>
                            <select name="" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="">Bank Account</label>
                            <select name="" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="">Payment Date</label>
                            <input type="text" name="paymentDate" class="form-control datepicker" id="paymentDate">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="">Cheque No</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Category Details</label>
                        <div id="addChequeCategoryDetails">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input class='ncheck_all_cheque' type='checkbox'
                                        onclick="select_all_cheques()" />
                                </div>
                                <div class="col-sm-2">
                                    <label>Category</label>
                                </div>
                                <div class="col-sm-3">
                                    <label>Description</label>
                                </div>
                                <div class="col-sm-2">
                                    <label>Amount</label>
                                </div>
                                <div class="col-sm-2">
                                    <label>Tax</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <input type="checkbox" class="deleteChequeCategory">
                                    <span id='nsnums'></span>
                                </div>
                                <div class="col-sm-3">
                                    <select name="account_id" class="form-control">
                                        @foreach ($accounts as $account)
                                            <option value="">
                                                {{ $account->name . ' --- ' . $account->category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" onclick="getTaxCalcs()">
                                        <option value="VAT16">VAT 16%</option>
                                        <option value="zeroRated">Zero Rate 0%</option>
                                        <option value="excempt">Excempt 0%</option>
                                        <option value="witholding">Witholding Rate 5%</option>
                                        <option value="reverse">Reverse Charge 5%</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-info mt-2 chequeCategory btn-sm btn-round" type="button">
                            Add Line
                        </button>
                        <button class="btn btn-sm mt-2 btn-sm btn-round btn-outline-danger" id="chequ"
                            type="button">
                            Remove
                        </button>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-outline-warning btn-round btn-sm" data-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-outline-success btn-round btn-sm">
                        Add Cheque
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var i = 2;
    $(".chequeCategory").click(function() {
        count = $("#addChequeCategoryDetails .row").length;
        var data = "<div class='row'>" +
            "<div class='col-sm-2'>" +
            "<input type='checkbox' class='deleteChequeCategory'>" +
            "</div>" +
            "<div class='col-sm-3 mt-2' id='account_name" + (i + 1) +
            "'><select onclick='getChequeAccounts(i)' class='form-control' id='name" + (i + 1) +
            "' name='name[" + (
                i - 1) + "]'>" +
            "<option></option>" +
            "</select>" +
            "</div>" +
            "<div class='col-sm-3 mt-2'><input type='text' class='form-control' id='description" + i +
            "' name='description[" + (i - 1) + "]'></div>" +
            "<div class='col-sm-2 mt-2'><input type='text' class='form-control' id='amount" + i +
            "' name='amount[" + (i - 1) + "]'></div>" +
            "<div class='col-sm-2 mt-2'>" +
            "<select id='tax" + i + "' name='tax[" + (i - 1) +
            "]' onclick='getTaxCalcs()' class='form-control'>" +
            "<option value='VAT16'>VAT 16%</option>" +
            "<option value='zeroRated'>Zero Rate 0%</option>" +
            "<option value='excempt'>Excempt 0%</option>" +
            "<option value='witholding'>Witholding Rate 5%</option>" +
            "<option value='reverse'>Reverse Charge 5%</option>" +
            "</select>" +
            "</div>" +
            "</div>";
        $("#addChequeCategoryDetails").append(data);
        i++;
    });

    function getChequeAccounts(i) {
        $.ajax({
            type: "GET",
            url: "expenses/accounts",
            success: function(response) {
                var output = '<select class="form-control">';
                for (let k = 0; k < response.accounts.length; k++) {
                    output += '<option value="' + response.accounts[k].id + '">' + response.accounts[k]
                        .name + '</option> ';
                }
                output += '</select>';
                document.getElementById('account_name' + i).innerHTML = output;
            }
        })
    }
    $("#chequ").click(function() {
        console.log('ji');
        if ($('.deleteChequeCategory:checkbox:checked').length > 0) {
            if (window.confirm("Are you sure you want to delete")) {
                $('.deleteChequeCategory:checkbox:checked').parents("#addCategoryDetails .row").remove();
                $('.ncheck_all_cheque').prop("checked", false);
            } else {
                $('.ncheck_all_cheque').prop("checked", false);
                $('.deleteChequeCategory').prop("checked", false);
            }

        }
    });

    function select_all_cheques() {
        $('input[class=deleteChequeCategory]:checkbox').each(function() {
            if ($('input[class=ncheck_all_cheque]:checkbox:checked').length == 0) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
    };

    function check() {
        obj = $('#addChequeCategoryDetails .row').find('span');
        $.each(obj, function(key, value) {
            id = value.id;
            $('#' + id).html(key + 1);
        });
    }
</script>