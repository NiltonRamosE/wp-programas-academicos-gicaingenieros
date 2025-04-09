jQuery(document).ready(function($) {
    let chart;
    
    const $canvas = $('#gicaStatesChart');
    
    if ($canvas.length) {
        initStatesChart();
    }
    
    function initStatesChart() {
        const ctx = $canvas[0].getContext('2d');
        const total = gicaChartData.states.active + gicaChartData.states.inactive + gicaChartData.states.outdated;
        
        chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Activos', 'Inactivos', 'Desactualizados'],
                datasets: [{
                    data: [
                        gicaChartData.states.active,
                        gicaChartData.states.inactive,
                        gicaChartData.states.outdated
                    ],
                    backgroundColor: [
                        gicaChartData.colors.active,
                        gicaChartData.colors.inactive,
                        gicaChartData.colors.outdated
                    ],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const percentage = Math.round((value / total) * 100);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        createCustomLegend(chart);
    }
    
    function createCustomLegend(chart) {
        const $legendContainer = $('.gica-dashboard__chart-legend');
        let legendItems = '';
        
        chart.data.labels.forEach((label, i) => {
            const value = chart.data.datasets[0].data[i];
            const percentage = Math.round((value / chart.data.datasets[0].data.reduce((a, b) => a + b, 0)) * 100);
            const color = chart.data.datasets[0].backgroundColor[i];
            
            legendItems += `
                <div class="gica-dashboard__chart-legend-item">
                    <span class="gica-dashboard__chart-legend-color" style="background-color: ${color}"></span>
                    <span>${label}: ${value} (${percentage}%)</span>
                </div>
            `;
        });
        
        $legendContainer.html(legendItems);
    }
    
    window.updateGicaChart = function(newData) {
        if (typeof chart !== 'undefined') {
            chart.data.datasets[0].data = [
                newData.active,
                newData.inactive,
                newData.outdated
            ];
            
            const total = newData.active + newData.inactive + newData.outdated;
            
            chart.update();
            
            createCustomLegend(chart);
            
            $('.gica-dashboard__chart-total').text(`Total: ${total} programas`);
        }
    };
});