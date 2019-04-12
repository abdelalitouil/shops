import { Component, OnInit } from "@angular/core";
import { Shop } from "../../_models/shop";
import { ShopService, AlertService } from "../../_services";

@Component({
  templateUrl: "./preferred_shop.component.html",
})
export class PreferredShopComponent implements OnInit {
  private shops: Shop[];
  private disabledBtn: number = 0;

  constructor(
    private shopService: ShopService,
    private alertService: AlertService,
  ) { }

  ngOnInit() {
    this.index();
  }

  // List of preferred shops
  index() {
    this.shopService.retrievePreferredShops().subscribe(
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

  // Remove shop from the preferred list
  onRemove(id: number) {
    this.disabledBtn = id;
    this.shopService.remove(id).subscribe(
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
