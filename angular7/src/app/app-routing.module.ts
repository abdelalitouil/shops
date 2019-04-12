import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent, RegisterComponent, NearbyShopComponent, PreferredShopComponent } from './_components';
import { AuthGuard } from "./_guards";

const routes: Routes = [
  { 
    path: '',   
    redirectTo: '/home', 
    pathMatch: 'full' 
  },
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: 'register',
    component: RegisterComponent
  },
  {
    path: 'home',
    component: NearbyShopComponent,
    canActivate: [AuthGuard]
  },
  {
    path: 'preferred-shops',
    component: PreferredShopComponent,
    canActivate: [AuthGuard]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }