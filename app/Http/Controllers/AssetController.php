<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetMove;
use App\Models\AssetMovement;
use App\Models\AssetPurchase;
use App\Models\Department;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $assets = Asset::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        $suppliers = Supplier::where('organization_id', Auth::user()->organization_id)->orderBy('id')->get();
        $categories = AssetCategory::where('organization_id', Auth::user()->organization_id)->orderBy('id')->get();
        $departments = Department::where('organization_id', Auth::user()->organization_id)->orderBy('id')->get();
        return view('assets.index', compact('suppliers', 'categories', 'departments','assets'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'asset_name' => 'required',
            'asset_category_id' => 'required',
            'supplier_id' => 'required',
            'asset_serial_no' => 'required',
            'department_id' => 'required',
            'location' => 'required',
        ], [
            'receipt_no' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
            'purchase_date' => 'required',
            'total_amount' => 'required',
        ]);
        if ($validate->fails())
        {
            toast('All Fields are required','info');
        }
        else{
            //dd($request->all());
            $image = $request->file('image')->store('assetsimages','public');
            $asset = new Asset();
            $asset->organization_id = Auth::user()->organization_id;
            $asset->asset_category_id = $request->asset_category_id;
            $asset->supplier_id = $request->supplier_id;
            $asset->asset_name = $request->asset_name;
            $asset->asset_serial_no = $request->asset_serial_no;
            $asset->department_id = $request->department_id;
            $asset->location = $request->location;
            $asset->image = $image;
            $asset->save();
            /*
             * Purchase
             * */
            $this->assetPurchase($asset->id,$request->supplier_id,$request);
            toast('Asset Added','success');
        }
        return redirect()->back();
    }
    public function assetPurchase($id,$supplierId,$request)
    {
        $purchase = new AssetPurchase();
        $purchase->supplier_id = $supplierId;
        $purchase->organization_id = Auth::user()->organization_id;
        $purchase->receipt_no =$request->receipt_no;
        $purchase->asset_id =$id;
        $purchase->quantity = $request->quantity;
        $purchase->amount = $request->amount;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->total_amount = $request->total_amount;
        $purchase->save();
    }
    public function assetMovement()
    {
        $moves = AssetMovement::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        $departments = Department::where('organization_id', Auth::user()->organization_id)->orderBy('id')->get();
        $assets = Asset::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        return view('assets.movement',compact('assets','departments','moves'));
    }
    public function checkDetails($id)
    {
        return Asset::where('id',$id)->where('organization_id',Auth::user()->organization_id)->with('purchase','department','category')->get();
    }
    public function moveAsset(Request  $request)
    {
        $asset = AssetPurchase::where('asset_id',$request->asset_id)->update(array(
            'quantity'=>$request->remaining,
        ));
        $move = new AssetMovement();
        $move->asset_id = $request->asset_id;
        $move->department_id = $request->department_id;
        $move->organization_id = Auth::user()->organization_id;
        $move->remaining = $request->remaining;
        $move->moved = $request->quantity;
        $move->maintenance = false;
        $move->save();
        toast('Successfully Moved Asset','success');
        return redirect()->back();
    }
}
