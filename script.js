document.getElementById('logHoursBtn').addEventListener('click', function () {
    document.getElementById('logHoursForm').style.display = 'block';
});

function closeForm() {
    document.getElementById('logHoursForm').style.display = 'none';
}

// Fetch logged hours and populate the table
fetch('fetch_hours.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const tableBody = document.querySelector('#hoursTable tbody');
        data.forEach(hour => {
            const formattedDate = new Date(hour.date).toLocaleDateString();  // Format to show only the date
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${formattedDate}</td>  <!-- Shows only the date -->
                <td>${hour.task_name}</td>
                <td>${hour.hours}</td>
                <td>${hour.task_description}</td>
                <td class="status ${hour.status}">${hour.status}</td>
            `;
            tableBody.appendChild(row);
        });
    })
    .catch(error => {
        console.error('Error fetching hours:', error);
        alert('There was an issue fetching the hours.');
    });

// Fetch the analytics data
fetch('get_analytics.php')
.then(response => response.json())
.then(data => {
    // Populate the analytics section with the fetched data
    document.querySelector('.stat-number:nth-child(1)').textContent = data.hours_today || 0;
    document.querySelector('.stat-number:nth-child(2)').textContent = data.hours_week || 0;
    document.querySelector('.stat-number:nth-child(3)').textContent = data.hours_month || 0;
})
.catch(error => {
    console.error('Error fetching analytics:', error);
});

