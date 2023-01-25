const fullyPaid = document.getElementById('fullyPaid');

new Chart(fullyPaid, {
    type: 'line',
    data: {
        labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: '# Fully Paid',
            data: [12000, 19000, 5000, 7000, 18900, 1820, 10000],
            backgroundColor: [
                '#ff8d34',
                // 'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                '#ff8d34',
            ],
            borderWidth: 2
        }]
    },
    options: {
        //   responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        elements: {
            line: {
                tension: 0.5
            }
        }
    }
});

const ctx = document.getElementById('gender');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Apprived', 'Rejected', ],
        datasets: [{
            label: '# Gender Count',
            data: [12, 19],
            backgroundColor: [
                '#6dd144',
                '#ff8d34',
            ],
            borderColor: [
                '#6dd144',
                '#ff8d34',
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: false,
        scales: {
            y: {
                beginAtZero: true,
                display: false,
            }
        }
    }
});


const expenses = document.getElementById('expenses');
new Chart(expenses, {
    // type: 'line',
    data: {
        labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
                type: 'line',
                label: 'Repayment',
                data: [12000, 19000, 5000, 7000, 18900, 1820, 10000],
                backgroundColor: [
                    '#6dd144'
                ],
                borderColor: [
                    '#6dd144'
                ],
                borderWidth: 2
            },
            {
                type: 'line',
                label: 'Borrowing',
                data: [1000, 1000, 50000, 70000, 1800, 11820, 1000],
                backgroundColor: [
                    '#ff8d34',
                ],
                borderColor: [
                    '#ff8d34',
                ],
                borderWidth: 2
            }
        ]
    },
    options: {
        //   responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        elements: {
            line: {
                tension: 0.5
            }
        }
    }
});
const loanReleased = document.getElementById('loanReleased');

new Chart(loanReleased, {
    type: 'line',
    data: {
        labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: '# Loans Approved',
            data: [12000, 19000, 5000, 7000, 18900, 1820, 10000],
            backgroundColor: [
                '#6dd144',
                // 'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                '#6dd144',
            ],
            borderWidth: 2
        }]
    },
    options: {
        //   responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        elements: {
            line: {
                tension: 0.5
            }
        }
    }
});
const loanCollection = document.getElementById('loanCollection');

new Chart(loanCollection, {
    type: 'line',
    data: {
        labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: '# Loans Collection',
            data: [12000, 19000, 5000, 7000, 18900, 1820, 10000],
            backgroundColor: [
                '#644ec5',
                // 'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                '#644ec5',
            ],
            borderWidth: 2
        }]
    },
    options: {
        //   responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        elements: {
            line: {
                tension: 0.5
            }
        }
    }
});
