//
//  UIKidPickerView.h
//  teaching
//
//  Created by kidliuxu on 14-4-2.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol UIKidPickerViewDelegate

-(void)didChoosePicker:(int) selectID;

@end

@interface UIKidPickerView : UIView <UIPickerViewDataSource, UIPickerViewDelegate>
{


}

@property (nonatomic, retain) UIPickerView *pickerView;
@property (nonatomic, assign) id<UIKidPickerViewDelegate> callback;
@property (nonatomic, retain) NSArray *dataList;

- (id)initWithFrame:(CGRect)frame pickerViewData:(NSArray *) _dataList;
- (void)setDefaultPickerSelectByID:(int)selectID;
//- (void) setCallbackDelegate:(id<UIKidPickerViewDelegate>) callbacDdelegate;

@end
