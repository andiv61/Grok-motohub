document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('scheduleForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const time = document.getElementById('scheduleTime').value;
    const clients = Array.from(document.getElementById('clientSelect').selectedOptions).map(opt => opt.value);
    const response = await fetch('/api/set-schedule', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ time, clients })
    });
    if (response.ok) alert('Расписание установлено!');
  });
});