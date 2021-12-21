import axios from 'axios';

const API_URL = '/api/';

class AuthService {
  login(user) {
    return axios
        .post(API_URL + 'login', {
            email: user.email,
            password: user.password
        })
        .then(response => {
            console.log(response)
            if (response.data.token) {
                //let us = axios.get(API_URL + 'user', { headers: {Authorization: 'Bearer ' + response.data.token } });
                fetch('api/user', {
                    headers: {Authorization: 'Bearer ' + response.data.token } 
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    let us = res;
                    us.token = response.data.token;
                    console.log(JSON.stringify(us));
                    localStorage.setItem('user', JSON.stringify(us));
                })
                
            }
        return response.data;
      });
  }

  logout() {
    localStorage.removeItem('user');
  }

  register(user) {
    return axios.post(API_URL + 'signup', {
      username: user.username,
      email: user.email,
      password: user.password
    });
  }
}

export default new AuthService();
