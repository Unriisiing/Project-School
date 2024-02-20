const login = document.querySelector('loginS');
const signup = document.querySelector('signupS');
const form = document.querySelector('#form');
const switchs = document.querySelector('switch');

function switchSignup() {
    document.querySelector('.login').style.display = 'none';
    document.querySelector('.signup').style.display = 'block';
    document.querySelector('.signupS').style.background = 'linear-gradient(45deg,#00d5fc,#046af6)';
    document.querySelector('.loginS').style.background = 'none';

}

function switchLogin() {
    document.querySelector('.login').style.display = 'block';
    document.querySelector('.signup').style.display = 'none';
    document.querySelector('.loginS').style.background = 'linear-gradient(45deg,#00d5fc,#046af6)';
    document.querySelector('.signupS').style.background = 'none';
}



