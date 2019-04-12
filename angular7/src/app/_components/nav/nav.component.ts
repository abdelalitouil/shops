import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { UserService } from "../../_services/user.service";

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html'
})
export class NavComponent implements OnInit {

  constructor(private userService: UserService, private router: Router) { }

  ngOnInit() {
  }

  logout() {
    this.userService.logout();
    this.router.navigate(
      ['/login']
    );
  }
}
