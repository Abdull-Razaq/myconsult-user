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
            const formattedDate = new Date(hour.date).toLocaleDateString();  
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${formattedDate}</td>  
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

   // Function to fetch the analytics data
   function fetchAnalytics() {
    fetch('get_analytics.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('hoursToday').innerText = data.hours_today;
            document.getElementById('hoursThisWeek').innerText = data.hours_week;
            document.getElementById('hoursThisMonth').innerText = data.hours_month;
        })
        .catch(error => {
            console.error('Error fetching analytics data:', error);
            alert('There was an issue fetching the analytics data.');
        });
}

// Call fetchAnalytics when the page is loaded
document.addEventListener('DOMContentLoaded', function() {
    fetchAnalytics();
});

function fetchUserDetails() {
    fetch('get_user.php')  
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                document.getElementById('greeting').innerText = `Hi, ${data.username}`;
            }
        })
        .catch(error => {
            console.error('Error fetching user details:', error);
        });
}

// Call this function when the page loads
document.addEventListener('DOMContentLoaded', fetchUserDetails);


