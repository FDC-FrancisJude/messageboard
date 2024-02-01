function formatTimeAgo(timestamp) {
    const now = new Date();
    const created = new Date(timestamp);
    const diffInSeconds = Math.floor((now - created) / 1000);

    if (diffInSeconds < 60) {
        return 'Now';
    } else if (diffInSeconds < 3600) {
        return Math.floor(diffInSeconds / 60) + ' minutes ago';
    } else if (diffInSeconds < 86400) {
        return Math.floor(diffInSeconds / 3600) + ' hours ago';
    } else {
        return Math.floor(diffInSeconds / 86400) + ' days ago';
    }
}

function formatFormalDate(dateString) {
    var date = new Date(dateString);

    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true // Use 12-hour format
    };

    return date.toLocaleString('en-US', options);
}
