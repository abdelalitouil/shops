import { Component, OnInit, Inject } from "@angular/core";
import { Shop } from "../../_models/shop";
import { ShopService, AlertService } from "../../_services";

@Component({
  templateUrl: "./nearby_shop.component.html",
})
export class NearbyShopComponent implements OnInit {
  private shops: Shop[];
  private disabledBtn: number = 0;

  constructor(
    private shopService: ShopService,
    private alertService: AlertService
  ) { }

  ngOnInit() {
    this.index();
  }

  // List of nearby shops
  index() {
    this.shopService.retrieveShops().subscribe(
      response => {
        this.shops = response.shops;
      },
      error => {
        this.alertService.create(
          "danger", 
          error
        );
      }
    );
  }

  // Add a shop to the preferred list
  onLike(id: number) {
    this.disabledBtn = id;
    this.shopService.like(id).subscribe(
      response => {
        this.alertService.create(
          "success", 
          response.message
        );
        document.getElementById(String(id)).remove();
        this.disabledBtn = 0;
      },
      error => {
        this.alertService.create(
          "danger", 
          error
        );
      }
    );
  }

  // Dislike a shop
  onDislike(id: number) {
    this.disabledBtn = id;
    this.shopService.dislike(id).subscribe(
      response => {
        this.alertService.create(
          "success", 
          response.message
        );
        document.getElementById(String(id)).remove();
        this.disabledBtn = 0;
      },
      error => {
        this.alertService.create(
          "danger", 
          error
        );
      }
    );
  }
}
