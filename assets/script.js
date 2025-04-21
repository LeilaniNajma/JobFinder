// Pencarian berdasarkan judul lowongan
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const jobCards = document.querySelectorAll('.job-card');
    
    jobCards.forEach(function(card) {
      const title = card.querySelector('h3').textContent.toLowerCase();
      if (title.includes(searchTerm)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
  
  // Filter berdasarkan kategori
  document.getElementById('categoryFilter').addEventListener('change', function() {
    const selectedCategory = this.value;
    const jobCards = document.querySelectorAll('.job-card');
    
    jobCards.forEach(function(card) {
      const category = card.getAttribute('data-category');
      if (selectedCategory === '' || selectedCategory === category) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
  
  // Validasi Form Login
  function validateLoginForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  
    if (!email || !emailRegex.test(email)) {
      alert("Please enter a valid email.");
      return false;
    }
  
    if (!password || password.length < 6) {
      alert("Password must be at least 6 characters.");
      return false;
    }
  
    return true;
  }
  
  // Validasi Form Register
  function validateRegisterForm() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  
    if (!name) {
      alert("Please enter your name.");
      return false;
    }
  
    if (!email || !emailRegex.test(email)) {
      alert("Please enter a valid email.");
      return false;
    }
  
    if (!password || password.length < 6) {
      alert("Password must be at least 6 characters.");
      return false;
    }
  
    if (password !== confirmPassword) {
      alert("Passwords do not match.");
      return false;
    }
  
    return true;
  }
  
  // Menampilkan konfirmasi sebelum menghapus lowongan
  function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this job listing?")) {
      window.location.href = "delete.php?id=" + id;
    }
  }
  
  // Menambahkan event listener pada form login dan register
  document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    if (!validateLoginForm()) {
      e.preventDefault();
    }
  });
  
  document.getElementById('registerForm')?.addEventListener('submit', function(e) {
    if (!validateRegisterForm()) {
      e.preventDefault();
    }
  });
  