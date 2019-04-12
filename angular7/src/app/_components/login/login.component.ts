import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { User } from "../../_models/user";
import { UserService, AlertService } from "../../_services";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
})
export class LoginComponent implements OnInit {
  private message: String;
  private user: User = {
    email: 'demo@unitedremote.com',
    password: 'demo',
    token: ''
  };
  private url: string;
  private isLoading: boolean = false;

  constructor(
    private userService: UserService,
    private route: ActivatedRoute,
    private router: Router,
    private alertService: AlertService) {
    if (this.userService.currentUser)
      this.router.navigate(['/'])
  }
  
  ngOnInit() {
    this.url = this.route.snapshot.queryParams['url'] || '/';
  }

  onSubmit() {
    this.isLoading = true;
    this.userService.login(this.user).then(
      user => {
        if (user && user.token) {
          localStorage.setItem('currentUser', JSON.stringify(user));
          this.userService.currentUserSubject.next(user);
          this.router.navigate([this.url]);
          this.isLoading = false;
        }
      },
      error => {
        console.log(error);
        this.isLoading = false;
        this.alertService.create(
          "danger", 
          error
        );
      }
    );
  }
}
