const loanCollection = document.getElementById('loanCollection');

new Chart(loanCollection, {
    type: 'line',
    data: {
        labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: '# Interest Posted',
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
const loanReleased = document.getElementById('loanReleased');

new Chart(loanReleased, {
    type: 'line',
    data: {
        labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: '# Interest Earned',
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
const expenses = document.getElementById('expenses');
new Chart(expenses, {
    // type: 'line',
    data: {
        labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
                type: 'line',
                label: 'Savings',
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
                label: 'Withdrawals',
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