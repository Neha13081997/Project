<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" class="form-control" name="name" value=" {{ isset($user) ? $user->name : ''}} ">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ isset($user) ? $user->email : ''}} ">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ isset($user) ? $user->phone : ''}}">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select">
                <option value="">@lang('global.pleaseSelect')</option>
                @if(isset($roles))
                @foreach($roles as $role)
                <option value="{{ $role->id }}"  {{ isset($user) && $user->roles->contains($role->id) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
