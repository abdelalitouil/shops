import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { User } from '../_models/user';
import { Alert } from '../_models';
import { environment } from './../../environments/environment';

@Injectable({
  providedIn: 'root'
})

export class UserService {
  currentUserSubject: BehaviorSubject<User>;
  currentUser: Observable<User>;

  constructor(private http: HttpClient) {
    this.currentUserSubject = new BehaviorSubject<User>(JSON.parse(localStorage.getItem('currentUser')));
    this.currentUser = this.currentUserSubject.asObservable();
  }

  // Receive the confirmation token from API, login the user
  async login(user: User) {
    let p: any = await this.getPosition();
    let payload = {
      security: {
        credentials: {
          email: user.email,
          password: user.password
        }
      },
      location: {
        latitude: p.coords.latitude,
        longitude: p.coords.longitude
      }
    }
    return this.http.post<User>(environment.apiUrl + '/auth/login', payload).toPromise()
  }

  // Regsiter user
  register(user: User): Observable<Alert> {
    let payload = {
      email: user.email,
      password: user.password
    }
    return this.http.put<Alert>(environment.apiUrl + '/auth/register', payload);
  }

  logout() {
    localStorage.removeItem('currentUser');
    this.currentUserSubject.next(null);
  }

  public get userObject(): User {
    return this.currentUserSubject.value;
  }

  public getPosition() {
    let options = {
      enableHighAccuracy: true,
      timeout: 5000,
      maximumAge: 0
    };
    return new Promise((resolve, reject) => {
      navigator.geolocation.getCurrentPosition(resolve, reject, options);
    });
  }

  public isAuthenticated(): boolean {
    return this.currentUserSubject.value ? true : false;
  }
}
