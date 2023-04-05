const form = document.querySelector('form');
const statusTxt = form.querySelector('.button-area span');

form.onsubmit = (e) => {
	e.preventDefault();

	statusTxt.style.color = '#0d6efd';
	statusTxt.style.display = 'block';

	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'message.php', true);

	xhr.onload = () => {
		if (xhr.readyState == 4 && xhr.status == 200) {
			let response = xhr.response;

			if (response.indexOf('이메일과 비밀번호를 입력해주세요.') != -1 || response.indexOf('유효한 이메일 주소를 입력하세요.')) {
				statusTxt.style.color = 'red';
			} else {
				form.reset();
				setTimeout(() => {
					statusTxt.style.display = 'none';
				}, 3000);
			}

			// console.log(response);
			// statusTxt.innerText = response;
		}
	};
	let formData = new FormData(form);
	xhr.send(formData);
};
