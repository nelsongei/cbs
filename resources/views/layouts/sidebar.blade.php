<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="divider"></div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="">
                    <a href="{{ url('home') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                        <span class="pcoded-mtext">Members</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('members') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Member Registration</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-target"></i></span>
                        <span class="pcoded-mtext">Savings Transactions</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('saving/accounts') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Saving Accounts</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/products') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Saving Schemes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Savings & Withdraw</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-activity"></i></span>
                        <span class="pcoded-mtext">Charge Management</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('charge') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Charges</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-pie-chart"></i></span>
                        <span class="pcoded-mtext">Loans</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('disbursements') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Disbursement Options</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('matrix') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Guarantor Matrix</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('loan/products') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loan Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('loan/loan_application') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loan Application</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/accounts') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loan Repayment</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-bar-chart"></i></span>
                        <span class="pcoded-mtext">Accounts</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('account/chart') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Chart Of Accounts</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('journals') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Journals</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('particulars') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Particulars</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('expenses') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Expenses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('income') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Income</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('petty/cash') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Petty Cash</span>
                            </a>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Budget</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('budget/projections') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Projections</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Banking</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('bank/accounts') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Bank Accounts</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('bank/deposit') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Bank Deposit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('bank/bankReconciliation/transact') }}"
                                        class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Disbursal & Payments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('bank/deposit') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Transactions</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-loader"></i></span>
                        <span class="pcoded-mtext">Assets</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('asset') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Assets</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('asset/movements') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Asset Movements</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('asset/categories') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Categories</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-monitor"></i></span>
                        <span class="pcoded-mtext">Reports</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('reports/members') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Members</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Shares</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('reports/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Savings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('reports/loans') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loans</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/reports/finance') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Financial</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="{{ url('licence') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                        <span class="pcoded-mtext">Licence Payments</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                        <span class="pcoded-mtext">Adminstration</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('users') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('organization') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Organization</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('asset/categories') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Roles</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
