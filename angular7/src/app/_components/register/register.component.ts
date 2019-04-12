import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { UserService, AlertService } from "../../_services";
import { User } from '../../_models';

@Component({
  selector: 'app-register',
  templateUrl: "./register.component.html",
})
export class RegisterComponent implements OnInit {
  private user: User = {
    email: '',
    password: '',
    token: ''
  };
  private isLoading: boolean = false;

  constructor(
    private userService: UserService,
    private alertService: AlertService,
    private router: Router
  ) { }

  ngOnInit() {
  }

  onSubmit() {
    this.isLoading = true;
    this.userService.register(this.user).subscribe(
      response => {
        this.isLoading = false;
        this.alertService.create(
          "success", 
          response.message
        );
        this.router.navigate(['login']);
      },
      error => {
        this.isLoading = false;
        this.alertService.create(
          "danger", 
          error
        );
      }
    );
  }
}
