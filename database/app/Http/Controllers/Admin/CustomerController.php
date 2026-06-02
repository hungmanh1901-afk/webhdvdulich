<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->withCount('bookings');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer): View
    {
        abort_unless($customer->isCustomer(), 404);

        $customer->loadCount('bookings');
        $bookings = $customer->bookings()
            ->with('guide')
            ->latest('id')
            ->paginate(10);

        return view('admin.customers.show', compact('customer', 'bookings'));
    }

    public function edit(User $customer): View
    {
        abort_unless($customer->isCustomer(), 404);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, User $customer): RedirectResponse
    {
        abort_unless($customer->isCustomer(), 404);

        $customer->update($request->validated());

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('success', 'Cập nhật khách hàng thành công.');
    }

    public function destroy(User $customer): RedirectResponse
    {
        abort_unless($customer->isCustomer(), 404);

        if ($customer->bookings()->exists()) {
            return back()->withErrors(['error' => 'Không thể xóa khách hàng đang có lịch đặt.']);
        }

        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Đã xóa khách hàng.');
    }
}
