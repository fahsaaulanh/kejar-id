// Render Function
$('#pts').on('click', function() {
    if (typeof window !== 'undefined') {
        localStorage.setItem('pts_title', $('#pts-1').html())
        window.location.href = '/student/mini_assessment';
    }
});
