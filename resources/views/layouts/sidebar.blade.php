<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="divider"></div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="">
                    <a href="{{ url('home')}}" class="waves-effect waves-dark">
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
                        <span class="pcoded-mtext">Savings</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{ url('saving/accounts') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Saving Accounts</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/products') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Saving Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Savings</span>
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
                            <a href="{{ url('saving/accounts') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loan Accounts</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('loan/products') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Loan Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Savings</span>
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
                            <a href="{{ url('saving/accounts') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Journals Entries</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/products') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Particulars</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Expenses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Income</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Petty Cash</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Budget</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('saving/savings') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Banking</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="{{ url('licence')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                        <span class="pcoded-mtext">Licence Payments</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
