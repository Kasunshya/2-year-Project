document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('activityChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'User Registrations',
                    data: [5, 12, 15, 10, 20, 25, 18, 22, 30, 35, 40, 50],
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderRadius: 10,
                },
                {
                    label: 'Tasks Completed',
                    type: 'line',
                    data: [8, 10, 12, 15, 14, 18, 16, 20, 22, 25, 30, 35],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 3,
                },
            ],
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'System Admin Activity Overview 2023',
                },
            },
        },
    });

    // Enhanced Calendar Implementation with Order Status
    const calendar = document.getElementById('calendar');
    const date = new Date();
    const currentMonth = date.getMonth();
    const currentYear = date.getFullYear();

    // Dummy order data with status
    const orderData = {
        completedOrders: [1, 5, 7, 10, 12, 15, 18, 22, 25, 28],
        nonCompletedOrders: [3, 6, 9, 13, 16, 20, 23, 26, 29]
    };

    function generateCalendar(month, year) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                           'July', 'August', 'September', 'October', 'November', 'December'];

        let calendarHTML = 
            `<div class="calendar-header">
                <h3>${monthNames[month]} ${year}</h3>
            </div>
            <div class="calendar-body">
                <div class="weekdays">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>
                <div class="days">`;

        // Add empty spaces for days before the first day of the month
        for (let i = 0; i < firstDay.getDay(); i++) {
            calendarHTML += '<div></div>';
        }

        // Add the days of the month
        for (let day = 1; day <= lastDay.getDate(); day++) {
            let dayClass = '';
            
            // Highlight order status
            if (orderData.completedOrders.includes(day)) {
                dayClass = 'completed-order';
            } else if (orderData.nonCompletedOrders.includes(day)) {
                dayClass = 'non-completed-order';
            }

            // Highlight today
            if (day === date.getDate() && month === date.getMonth()) {
                dayClass += ' today';
            }

            calendarHTML += `<div class="${dayClass}">${day}</div>`;
        }

        calendarHTML += `</div></div>`;

        calendar.innerHTML = calendarHTML;
    }

    generateCalendar(currentMonth, currentYear);
});